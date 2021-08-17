import 'dart:ffi';

import 'package:flutter/material.dart';
import 'package:rutanceria/generals/dialogs.dart';
import 'package:rutanceria/models/lokasi.dart';
import 'package:rutanceria/models/session.dart';
import 'package:rutanceria/generals/inputdata.dart';

class FormInputLokasi extends StatefulWidget{
  final Session session;
  final List list;
  final int index;
  FormInputLokasi(this.session,{this.list,this.index});

  @override
  _FormInputLokasiState createState() => _FormInputLokasiState();
  
}
class _FormInputLokasiState extends State<FormInputLokasi>{
  String kodeLokasi = "";
  String namaLokasi = "";
  int areaUmum = 0;

  bool _proses = false;
  @override

  void initState(){
    _proses=false;

    if(this.widget.list == null){
      kodeLokasi = '';
      namaLokasi = '';
      areaUmum = 0;
    }
    else{
      kodeLokasi = this.widget.list[this.widget.index]["KodeLokasi"];
      namaLokasi = this.widget.list[this.widget.index]["NamaLokasi"];
      areaUmum = int.parse(this.widget.list[this.widget.index]["AreaUmum"].toString());
    }
    super.initState();
  }
  void _prosesSimpanData() async{
    setState(() {
      _proses = true;
    });
    Map param(){
      return{
        'KodeLokasi' : kodeLokasi.toString(),
        'NamaLokasi' : namaLokasi.toString(),
        'AreaUmum'   : areaUmum.toString(),
        'formtype'   : this.widget.list == null ? 'add' : 'edit'
      };
    }
    Lokasi data = new Lokasi(this.widget.session, param: param());

    try{
      await data.crudLokasi();
      Navigator.pop(context);
    }
    catch(e){
      print(e.toString());
      messageBox(context: context,title: "Error",message: e.toString());
      setState(() {
      _proses=false; 
      });
    }
  }
  @override
  Widget build(BuildContext context) {
    // TODO: implement build
    return Scaffold(
      appBar: AppBar(
        title: Text(this.widget.list == null ? "Add Data Lokasi " : "Edit Data Lokasi"),
        actions: [
          !_proses ?
          FlatButton(
            child: Text("Simpan", 
                      style: TextStyle(color: Colors.white, fontSize: 16),), 
                      onPressed: (){
                        _prosesSimpanData();
                      },
            )
          : Container()
        ],
      ),
      body: ListView(
        padding: EdgeInsets.all(5),
        children: <Widget>[
          // Kode Lokasi
          ExpansionTile(
            initiallyExpanded: true,
            title: Text("Kode Lokasi", style: TextStyle(color: Theme.of(context).primaryColorDark),),
            children: [
              _inputDataString(
                  title:"Kode Lokasi", 
                  label:"", 
                  dataField:this.kodeLokasi == "" ? "-" : this.kodeLokasi, 
                  description:"", 
                  onChange: (v) => setState( () => this.kodeLokasi = v),
                  readonly: this.widget.list == null ? false : true
              ),
            ],
          ),

          // Nama Lokasi

          ExpansionTile(
            initiallyExpanded: true,
            title: Text("Nama Lokasi", style: TextStyle(color: Theme.of(context).primaryColorDark),),
            children: [
              _inputDataString(
                  title:"Nama Lokasi", 
                  label:"", 
                  dataField:this.namaLokasi == "" ? "-" : this.namaLokasi, 
                  description:"", 
                  onChange: (v) => setState( () => this.namaLokasi = v)
              ),
            ],
          ),

          // Set Sebagai Lokasi Umum

          ExpansionTile(
            initiallyExpanded: true,
            title: Text("Lokasi Umum ?", style: TextStyle(color: Theme.of(context).primaryColorDark),),
            children: [
              ListTile(
                leading: Switch(
                  value: areaUmum.toString() == "0" ? false : true , 
                  onChanged: (v){
                    if(v){
                      areaUmum = 1;
                    }
                    else{
                      areaUmum = 0;
                    }
                    setState(() {});
                    print(areaUmum);
                  }
                ),
              )
            ],
          ),
          Padding(
            padding: const EdgeInsets.fromLTRB(50, 20, 50, 20),
            child: RaisedButton( 
              elevation: .0,
              shape: StadiumBorder(),
              color: Theme.of(context).primaryColorDark,
              child: Text("Simpan Data", style: TextStyle(fontSize: 16, color: Colors.white)),
              onPressed: () {
                _prosesSimpanData();
              },
            ),
          )
        ],
      ),
    );

  }
  Widget _inputDataString({String title, String label, dynamic dataField,String description="",void Function(dynamic value) onChange, bool readonly = false}) {

    return ListTile( 
          contentPadding: const EdgeInsets.only(left: 15, right: 20),
          title: Text("$dataField", style: TextStyle(color: Colors.green, fontSize: 16, fontWeight: FontWeight.bold)),        
          onTap: !readonly ? () async{
              var data = await inputString(
                context: context, 
                title: "$title",
                label: "$label", 
                data:dataField,
                description: "$description",
              );
              if(data != null) {
                onChange(data);
              }
          }
          : null
      );
    }
}