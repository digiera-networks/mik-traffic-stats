## Mik-traffic-stats - A tool for monitoring and reporting traffic on Mikrotik routers
### Features
![screenshot](https://github.com/digiera-networks/mik-traffic-stats/raw/27f97e8b251bda7c9292abdd922046860031b0a4/screenshot.jpg?raw=true)
 - Monitoring and reporting egress and ingress traffic on the WAN interface of Mikrotik routers (daily, monthly and yearly) using passthrough mangle rules.
 - Utilizing SQLite to store data, hence straightforward deployment, customization and transition.
 - The monitoring server can be on the internal network or external one (using a low-power Raspberry Pi is ideal).
### Installation
1. Put the three **PHP files** on your web server and take note of their path. Be sure to set the correct **permissions** so that the database file is writable.
2. On the mikrotik router, create the following **mangle rules** for traffic monitoring.
```
/ip firewall mangle
add action=passthrough chain=forward comment=wan-tx out-interface=pppoe-vnpt
add action=passthrough chain=forward comment=wan-rx in-interface=pppoe-vnpt
```
Please bear in mind that **fasttrack must be disabled** to ensure the accuracy of the data!

3. Test this script using the **Scripts** function on the Mikrotik router to make sure that it is functional.
Remember to change the **address** in the script to **match yours**.
```
:local sysnumber [/system routerboard get value-name=serial-number]
:local txbytes [/ip firewall mangle { get [find comment=wan-tx] bytes }]
:local rxbytes [/ip firewall mangle { get [find comment=wan-rx] bytes }]
/tool fetch url=("http://1.2.3.4/mikstats/collector.php\?sn=$sysnumber&tx=$txbytes&rx=$rxbytes") mode=http keep-result=no
/ip firewall mangle reset-counters [/ip firewall mangle find comment=wan-tx]
/ip firewall mangle reset-counters [/ip firewall mangle find comment=wan-rx]
:log info ("WAN traffic counters have been reset!")
```
4. If all is well, put the script in the **Scheduler** and set it to run every 30 minutes.
```
/system scheduler
add interval=30m name=cap_nhat_traffic on-event=":local sysnumber [/system rou\
    terboard get value-name=serial-number]\r\
    \n:local txbytes [/ip firewall mangle { get [find comment=wan-tx] bytes }]\
    \r\
    \n:local rxbytes [/ip firewall mangle { get [find comment=wan-rx] bytes }]\
    \r\
    \n/tool fetch url=(\"http://1.2.3.4/mikstats/collector.php\\\?sn=\$sy\
    snumber&tx=\$txbytes&rx=\$rxbytes\") mode=http keep-result=no\r\
    \n/ip firewall mangle reset-counters [/ip firewall mangle find comment=wan\
    -tx]\r\
    \n/ip firewall mangle reset-counters [/ip firewall mangle find comment=wan\
    -rx]\r\
    \n:log info (\"WAN traffic counters have been reset!")" policy=\
    ftp,reboot,read,write,policy,test,password,sniff,sensitive,romon \
    start-time=startup
```
5. Voilà! Check your results by browsing to the path of **index.php**!
### Credits
Some of my codes come from the tikstat project https://github.com/mrkrasser/tikstat
### Contact info
- **Trương Anh Tuấn - DigiEra Networks**
- **Tel:** (+84) 0984 598 600
- **FB:** https://www.facebook.com/truonganhtuan
