#include<SPI.h>
#include<MFRC522.h>
#include<SoftwareSerial.h>
#include <Ethernet.h>
#define SS_PIN 4 //FOR RFID SS PIN BECASUSE WE ARE USING BOTH ETHERNET SHIELD AND RS-522
#define RST_PIN 9
#define No_Of_Card 3
byte mac[] = { 0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED };
char server[] = "192.168.43.225";   //YOUR SERVER
IPAddress ip(192, 168, 0, 104);
EthernetClient client;
SoftwareSerial mySerial(8,9);     
MFRC522 rfid(SS_PIN,RST_PIN);
MFRC522::MIFARE_Key key; 
byte id[12][4]={
  {165,163,80,214},             //RFID NO-1
  {112,224,72,84},             //RFID NO-2
  {129,25,120,137},
  {165,46,86,214},
  {245,26,88,214},
  {101,85,77,214},
  {197,206,80,214},
  {101,182,80,214},
  {197,40,88,214},
  {245,84,78,214},
  {213,36,88,214},
  {165,29,78,214},
  
};
byte id_temp[12][4];
byte i;
int j=0;
int x[3];

unsigned long uid;
void setup()
{
  Serial.begin(9600);
  mySerial.begin(9600);
  SPI.begin();
  rfid.PCD_Init();
  for(byte i=0;i<6;i++)
  {
    key.keyByte[i]=0xFF;
  }
  if (Ethernet.begin(mac) == 0) {
    Serial.println("Failed to configure Ethernet using DHCP");
    Ethernet.begin(mac, ip);
  }
  delay(1000);
  Serial.println("connecting...");
 }
void loop()
{int m=0;
  if(!rfid.PICC_IsNewCardPresent())
  return;
  if(!rfid.PICC_ReadCardSerial())
  return;
  rfid.PICC_DumpToSerial(&(rfid.uid));
 /* Serial.print("UID tag :");
  String content= "";
  byte letter;
  for (byte i = 0; i < rfid.uid.size; i++) 
  {
     Serial.print(rfid.uid.uidByte[i] < 0x10 ? " 0" : " ");
     Serial.print(rfid.uid.uidByte[i], HEX);
     content.concat(String(rfid.uid.uidByte[i] < 0x10 ? " 0" : " "));
     content.concat(String(rfid.uid.uidByte[i], HEX));
  }
  Serial.println(); */
    /*    Serial.println("inVALID");
         Serial.print("your card no :");
                  for(int s=0;s<4;s++)
                  {
                    Serial.print(rfid.uid.uidByte[s]);
                    Serial.print(" ");
                   
                  }
      if(rfid.PICC_IsNewCardPresent()) {
       uid = getID();
       if(uid != -1){
        Serial.print("Card detected, UID: "); Serial.println(uid);
       }
      } */
  for(i=0;i<4;i++)
  {
   id_temp[0][i]=rfid.uid.uidByte[i]; 
             delay(50);
  }
  
   for(i=0;i<12;i++)
  {
          if(id[i][0]==id_temp[0][0])
          {
            if(id[i][1]==id_temp[0][1])
            {
              if(id[i][2]==id_temp[0][2])
              {
                if(id[i][3]==id_temp[0][3])
                {
                  Serial.print("your card no :");
                  for(int s=0;s<4;s++)
                  {
                    Serial.print(rfid.uid.uidByte[s]);
                    x[s]=rfid.uid.uidByte[s];
                    Serial.print(" ");
                   
                  }
                  Serial.println("\nVALID");
                  Sending_To_DB(x);
                  j=0;
                            
                            rfid.PICC_HaltA(); rfid.PCD_StopCrypto1();   return; 
                }
              }
            }
          }
   else
   {j++;
    if(j==No_Of_Card)
    {
      Sending_To_DB(x);
      j=0;
    }
   }
  }

     // Halt PICC
  rfid.PICC_HaltA();

  // Stop encryption on PCD
  rfid.PCD_StopCrypto1();
 }
  unsigned long getID(){
  if ( ! rfid.PICC_ReadCardSerial()) { //Since a PICC placed get Serial and continue
    return -1;
  }
  unsigned long hex_num;
  hex_num =  rfid.uid.uidByte[0] << 24;
  hex_num += rfid.uid.uidByte[1] << 16;
  hex_num += rfid.uid.uidByte[2] <<  8;
  hex_num += rfid.uid.uidByte[3];
  rfid.PICC_HaltA(); // Stop reading
  return hex_num;
}


 void Sending_To_DB(int x[])   //CONNECTING WITH MYSQL
 {
    if (client.connect(server, 80)) {
    Serial.println("connected");
    // Make a HTTP request:
    client.print("GET /rac.php?code=");//YOUR URL
    client.print(x[0]);
    client.print(x[1]);
    client.print(x[2]);
    client.print(x[3]);
    client.print(" ");      //SPACE BEFORE HTTP/1.1
    client.println();
     if(j!=No_Of_Card)
    {
      client.print('1');
    }
    else
    {
      client.print('0');
    }
    
    client.print("&id=");
    for(int s=0;s<4;s++)
                  {
                    client.print(rfid.uid.uidByte[s]);
                                  
                  }
    client.print(" ");      //SPACE BEFORE HTTP/1.1
    client.print("HTTP/1.1");
    client.println();
    client.println("Host: www.XXXXXXXXXX.com");
    client.println("Connection: close");
    client.println();
  } else {
    // if you didn't get a connection to the server:
    Serial.println("connection failed");
  }
  client.stop();
 }
