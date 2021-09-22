import 'package:flutter/material.dart';
import 'package:http/http.dart';
import 'package:rutanceria/generals/dialogs.dart';
import 'package:rutanceria/home.dart';
import 'package:rutanceria/models/session.dart';
import 'package:rutanceria/models/login.dart';
import 'package:rutanceria/models/tahanan.dart';
import 'package:intl/intl.dart';
// import 'package:rutanceria/pages/home.dart';

class DetailTahanan extends StatefulWidget {
  final Session session;
  final String kriteria;
  DetailTahanan(this.session, this.kriteria);
  @override
  _DetailTahananState createState() => _DetailTahananState();
}

class _DetailTahananState extends State<DetailTahanan> {
  Map data;
  String kodetahanan;
  Map param(){
    return{
      'Kriteria' : this.widget.kriteria.toString()
    };
  }
  DateTime selectedDate = DateTime.now();
  _selectDate(BuildContext context) async {
    final DateTime picked = await showDatePicker(
      context: context,
      initialDate: selectedDate,
      firstDate: DateTime(2000),
      lastDate: DateTime(2025),
    );
    if (picked != null && picked != selectedDate)
      setState(() {
        selectedDate = picked.toLocal();
      });
      print(selectedDate);
  }
  @override
  void initState() {
    super.initState();
  }
  @override
  Widget build(BuildContext context) {
    var width = MediaQuery.of(context).size.width / 100;
    var height = MediaQuery.of(context).size.height / 100;
    return Scaffold(
      appBar: AppBar(
        title: Text(this.widget.session.appName),
      ),
      body: FutureBuilder(
        future: Tahanan(this.widget.session, param: param()).geTahanan(),
        builder: (context, snapshot){
          if (snapshot.hasError) print(snapshot.error);
          return snapshot.hasData
            ? showWidget(snapshot.data["data"])
            : new Center(
                  child: new CircularProgressIndicator(),
              );
        }
      )
    );
  }

  Widget showWidget(List listdata){
    var width = MediaQuery.of(context).size.width / 100;
    var height = MediaQuery.of(context).size.height / 100;
    return listdata.length > 0 ? Container(
        width: width * 100,
        height: height * 100,
        child: ListView(
          children: [
            SizedBox(height: 10,),
            Row(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                Container(
                  padding: EdgeInsets.all(5),
                  width: width * 40,
                  height: height * 30,
                  // color: Colors.black,
                  child: Card(
                    child: Image.network(listdata[0]["Attachment"]),
                  ),
                )
              ],
            ),
            SizedBox(height: 5,),
            Divider(),
            SizedBox(height: 5,),
            Container(
              child: Center(
                child: Text(
                  "Detail Tahanan",
                  style: TextStyle(
                    fontFamily: "Arial",
                    fontSize: 24,
                    fontWeight: FontWeight.bold
                  ),
                ),
              ),
            ),
            SizedBox(height: 5,),
            Container(
              padding: EdgeInsets.all(5),
              child: ListTile(
                title: Text(
                  "Nama Tahanan",
                  style: TextStyle(
                    fontFamily: "Arial",
                    fontSize: 16,
                    fontWeight: FontWeight.bold
                  ),
                ),
                trailing: Text(
                  listdata[0]["NamaTahanan"],
                  style: TextStyle(
                    fontFamily: "Arial",
                    fontSize: 16,
                  ),
                ),
              ),
            ),
            Container(
              padding: EdgeInsets.all(5),
              child: ListTile(
                title: Text(
                  "Kamar ",
                  style: TextStyle(
                    fontFamily: "Arial",
                    fontSize: 16,
                    fontWeight: FontWeight.bold
                  ),
                ),
                trailing: Text(
                  listdata[0]["NamaLokasi"],
                  style: TextStyle(
                    fontFamily: "Arial",
                    fontSize: 16,
                  ),
                ),
              ),
            ),
            Container(
              padding: EdgeInsets.all(5),
              child: ListTile(
                title: Text(
                  "Tanggal Masuk Tahanan",
                  style: TextStyle(
                    fontFamily: "Arial",
                    fontSize: 16,
                    fontWeight: FontWeight.bold
                  ),
                ),
                trailing: Text(
                  listdata[0]["TglMasuk"],
                  style: TextStyle(
                    fontFamily: "Arial",
                    fontSize: 16,
                  ),
                ),
              ),
            ),
            Container(
              padding: EdgeInsets.all(5),
              child: ListTile(
                title: Text(
                  "Asal Tahanan",
                  style: TextStyle(
                    fontFamily: "Arial",
                    fontSize: 16,
                    fontWeight: FontWeight.bold
                  ),
                ),
                trailing: Text(
                  listdata[0]["AsalTahanan"],
                  style: TextStyle(
                    fontFamily: "Arial",
                    fontSize: 16,
                  ),
                ),
              ),
            ),
            Divider(),
            Container(
              child: Center(
                child: Text(
                  "Lokasi Yang dikunjungi",
                  style: TextStyle(
                    fontFamily: "Arial",
                    fontSize: 24,
                    fontWeight: FontWeight.bold
                  ),
                ),
              ),
            ),
            Divider(),
            ListTile(
              title: Center(child: Text("Tanggal"),),
              subtitle: Center(
                child: GestureDetector(
                  child: Padding(
                    padding: EdgeInsets.all(12),
                    child: Text(
                      selectedDate.toString().split(' ')[0],
                      style: TextStyle(
                        color: Colors.red,
                        fontSize: 26,
                        fontWeight: FontWeight.w500,
                      ),
                    ),
                  ),
                  onTap: (){
                    _selectDate(context);
                    print(selectedDate);
                  },
                ),
              ),
            ),
            Divider(),
            FutureBuilder(
              future: Tahanan(widget.session).readLog(selectedDate.toString(), listdata[0]["KodeTahanan"].toString()),
              builder: (context, snapshot) {
                if (snapshot.hasError) print(snapshot.error);
                return snapshot.hasData
                    ? datalog(snapshot.data["data"])
                    : new Center(
                          child: new CircularProgressIndicator(),
                      );
              },
            )
          ],
        ),
      ): Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Center(child: Text("Tidak Ada Data"),)
        ],
      );
  }

  Widget datalog(List datalog){
    var width = MediaQuery.of(context).size.width / 100;
    var height = MediaQuery.of(context).size.height / 100;
    return Container(
      width: width * 100,
      height: height * 70,
      // color: Colors.black,
      child: ListView.builder(
        itemCount: datalog == null ? 0 : datalog.length,
        itemBuilder: (context, index) {
          DateTime tempDate = new DateFormat("yyyy-MM-dd hh:mm:ss").parse(datalog[index]["TanggalTransaksi"]);
          return Card(
                    child: ListTile(
                      title: Text(datalog[index]["NamaLokasi"]),
                      subtitle: Text(datalog[index]["KodeLokasi"]),
                      trailing: Text(DateFormat('kk:mm:a').format(tempDate)),
                      leading: Container(
                            width: width * 10 ,
                            child: Row(
                              mainAxisAlignment: MainAxisAlignment.end,
                              children: [
                                Container(
                                  width: width * 10,
                                  child: datalog[index]["Transaksi"] == "1" ? CircleAvatar(
                                    backgroundColor: Colors.green,
                                    foregroundColor: Colors.white,
                                    child: Text("IN"),
                                  ) : CircleAvatar(
                                    backgroundColor: Colors.red,
                                    foregroundColor: Colors.white,
                                    child: Text("OUT"),
                                  )
                                ),
                              ],
                            ),
                          ),
                    ),
                  );
        },
      )
    );
  }
}

