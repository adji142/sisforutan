import 'dart:convert';
import 'dart:ffi';
import 'dart:io';

import 'package:flutter/material.dart';
import 'package:rutanceria/generals/dialogs.dart';
import 'package:rutanceria/generals/lookup.dart';
import 'package:rutanceria/models/lokasi.dart';
import 'package:rutanceria/models/session.dart';
import 'package:rutanceria/generals/inputdata.dart';
import 'package:rutanceria/models/tahanan.dart';
import 'package:image_picker/image_picker.dart';

class FormInputTahanan extends StatefulWidget{
  final Session session;
  final List list;
  final int index;
  FormInputTahanan(this.session,{this.list,this.index});

  @override
  _FormInputTahananState createState() => _FormInputTahananState();
  
}
class _FormInputTahananState extends State<FormInputTahanan>{
  String kodeTahanan = "";
  String namaTahanan = "";
  String asalTahanan = "";
  DateTime tglMasuk = DateTime.now();
  double lamaTahanan = 0.0;
  String kodeLokasi = "";
  String namaLokasi = "";
  int statusTahanan = 1;
  String attachment = "";

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
    }

  bool _proses = false;
  @override

  void initState(){
    _proses=false;

    if(this.widget.list == null){
      kodeTahanan = "";
      namaTahanan = "";
      asalTahanan = "";
      tglMasuk = DateTime.now();
      lamaTahanan = 0.0;
      kodeLokasi = "";
      statusTahanan = 1;
      attachment = "";
    }
    else{
      kodeTahanan = this.widget.list[this.widget.index]["KodeTahanan"];
      namaTahanan = this.widget.list[this.widget.index]["NamaTahanan"];
      asalTahanan = this.widget.list[this.widget.index]["AsalTahanan"];
      tglMasuk = DateTime.parse(this.widget.list[this.widget.index]["TglMasuk"]);
      lamaTahanan = double.parse(this.widget.list[this.widget.index]["LamaTahanan"]);
      kodeLokasi = this.widget.list[this.widget.index]["KodeLokasi"];
      namaLokasi = this.widget.list[this.widget.index]["NamaLokasi"];
      statusTahanan = int.parse(this.widget.list[this.widget.index]["StatusTahanan"]);
      attachment = this.widget.list[this.widget.index]["Attachment"];

    }
    super.initState();
  }
  void _prosesSimpanData() async{
    setState(() {
      _proses = true;
    });
    Map param(){
      return{
        'KodeTahanan' : kodeTahanan.toString(),
        'NamaTahanan' : namaTahanan.toString(),
        'AsalTahanan'   : asalTahanan.toString(),
        'TglMasuk'    : tglMasuk.toString(),
        'LamaTahanan' : lamaTahanan.toString(),
        'KodeLokasi'  : kodeLokasi.toString(),
        'StatusTahanan' : statusTahanan.toString(),
        'NamaLokasi' : namaLokasi.toString(),
        'formtype'   : this.widget.list == null ? 'add' : 'edit',
        'baseimage'     : image64.toString(),
        'imagename'     : extentionPath.toString(),
        'Attachment' : attachment.toString()
      };
    }
    Tahanan data = new Tahanan(this.widget.session, param: param());

    try{
      await data.crudTahanan();
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

  var _imageFile;
  File imageFile;
  List pathext;
  String extentionPath;
  String image64 = "";

  _openGalery(BuildContext context) async{
    var picture = await ImagePicker.pickImage(source: ImageSource.gallery,maxHeight: 600).then((value) {
      this.setState((){
        imageFile = value;
        pathext = value.uri.toString().split("/");
        extentionPath = pathext[pathext.length-1].toString();
        if (imageFile != null){
          final bites = imageFile.readAsBytesSync();
          setState(() {
            image64 = base64Encode(bites);
          });
        }
      }); 
      Navigator.of(context).pop();
      print(image64);
    });
  }

    _openCamera(BuildContext context)async{
    var picture = await ImagePicker.pickImage(source: ImageSource.camera,maxHeight: 600).then((value) {
      this.setState((){
        imageFile = value;
        pathext = value.uri.toString().split("/");
        extentionPath = pathext[pathext.length-1].toString();

        if (imageFile != null){
          final bites = imageFile.readAsBytesSync();
          setState(() {
            image64 = base64Encode(bites);
            print(image64);
          });
        }

      }); 
      Navigator.of(context).pop();
    });
  }

    Future<void> _showChoiceDialog(BuildContext context){
    return showDialog(context: context,builder: (BuildContext contex){
      return AlertDialog(
        content: SingleChildScrollView(
          child: ListBody(
            children: <Widget>[
              ListTile(
                title: Text("Galeri"),
                leading: Icon(Icons.photo),
                onTap: (){
                  _openGalery(context);
                  if(imageFile != null){
                    final bites = File(imageFile.toString()).readAsBytesSync();
                    setState(() {
                      image64 = base64Encode(bites);
                    });
                    print(image64);
                  }
                },
              ),
              ListTile(
                title: Text("Camera"),
                leading: Icon(Icons.camera),
                onTap: (){
                  _openCamera(context);
                  if(imageFile != null){
                    final bites = File(imageFile.toString()).readAsBytesSync();
                    setState(() {
                      image64 = base64Encode(bites);
                    });
                    print(image64);
                  }
                },
              ),
            ],
          ),
        ),
      );
    });
  }

  @override
  Widget build(BuildContext context) {
    // TODO: implement build
    var width = MediaQuery.of(context).size.width / 100;
    var height = MediaQuery.of(context).size.height / 100;

    return Scaffold(
      appBar: AppBar(
        title: Text(this.widget.list == null ? "Add Data Tahanan " : "Edit Data Tahanan"),
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
          ExpansionTile(
            initiallyExpanded: true,
            title: Text("Foto", style: TextStyle(color: Theme.of(context).primaryColorDark),),
            children: [
              Container(
                width: width * 30,
                height: width * 30,
                child: Padding(
                  padding: EdgeInsets.all(5),
                  child: GestureDetector(
                    child: Card(
                      child:  imageFile == null 
                      ? this.widget.list[this.widget.index]["Attachment"] == '' ? Center(child: Icon(Icons.camera_alt),) : Image.network(this.widget.list[this.widget.index]["Attachment"])
                      : this.widget.list[this.widget.index]["Attachment"] == '' ? Image.file(File(imageFile.path)) : Image.network(this.widget.list[this.widget.index]["Attachment"]),
                    ),
                    onTap: (){
                      _showChoiceDialog(context);
                    },
                  )
                ),
              )
            ],
          ),

          // Kode Tahanan
          ExpansionTile(
            initiallyExpanded: true,
            title: Text("Kode Tahanan", style: TextStyle(color: Theme.of(context).primaryColorDark),),
            children: [
              _inputDataString(
                  title:"Kode Tahanan", 
                  label:"", 
                  dataField:this.kodeTahanan == "" ? "-" : this.kodeTahanan, 
                  description:"", 
                  onChange: (v) => setState( () => this.kodeTahanan = v),
                  readonly: this.widget.list == null ? false : true
              ),
            ],
          ),

          // Nama tahanan

          ExpansionTile(
            initiallyExpanded: true,
            title: Text("Nama Tahanan", style: TextStyle(color: Theme.of(context).primaryColorDark),),
            children: [
              _inputDataString(
                  title:"Nama Tahanan", 
                  label:"", 
                  dataField:this.namaTahanan == "" ? "-" : this.namaTahanan, 
                  description:"", 
                  onChange: (v) => setState( () => this.namaTahanan = v)
              ),
            ],
          ),

          // Asal tahanan

          ExpansionTile(
            initiallyExpanded: true,
            title: Text("Asal Tahanan", style: TextStyle(color: Theme.of(context).primaryColorDark),),
            children: [
              _inputDataString(
                  title:"Asal Tahanan", 
                  label:"", 
                  dataField:this.asalTahanan == "" ? "-" : this.asalTahanan, 
                  description:"", 
                  onChange: (v) => setState( () => this.asalTahanan = v)
              ),
            ],
          ),

          // TglMasuk

          ExpansionTile(
            initiallyExpanded: true,
            title: Text("Tanggal Masuk", style: TextStyle(color: Theme.of(context).primaryColorDark),),
            children: [
              GestureDetector(
                child: Padding(
                  padding: EdgeInsets.all(12),
                  child: Text(
                    selectedDate.toString().split(' ')[0],
                    style: TextStyle(
                      color: Colors.red,
                      fontSize: 16,
                      fontWeight: FontWeight.w500,
                    ),
                  ),
                ),
                onTap: (){
                  _selectDate(context);
                  setState(() {
                    
                  });
                  print(selectedDate);
                },
              )
            ],
          ),

          // Lama Tahanan

          ExpansionTile(
            initiallyExpanded: true,
            title: Text("Lama Masa Tahanan", style: TextStyle(color: Theme.of(context).primaryColorDark),),
            children: [
              _inputDataNumeric(
                  title:"Input Data", 
                  label:"Lama Masa Tahanan", 
                  dataField:this.lamaTahanan, 
                  uom:"", 
                  description:"Isikan Lama Masa Tahanan", 
                  onChange: (v) => setState( () => this.lamaTahanan = v)
              ),
            ],
          ),

          // Lokasi Kamar

          ExpansionTile(
            initiallyExpanded: true,
            title: Text("Lokasi Kamar", style: TextStyle(color: Theme.of(context).primaryColorDark),),
            children: [
              ListTile(
                title: kodeLokasi == ""
                          ? Text("<PILIH LOKASI>", style: TextStyle(color: Colors.red))
                          : Text(namaLokasi, style: TextStyle(fontSize: 16, color: Colors.black, fontWeight: FontWeight.bold),),
                trailing: Icon(Icons.keyboard_arrow_right, color: Theme.of(context).primaryColor,),
                onTap: () async{
                  Map paramlokasi(){
                    return {
                      'KodeLokasi'  : '',
                      'Kriteria'    : '',
                      'isUmum'      : '0'
                    };
                  }
                  var result = await Navigator.push(context, 
                                    MaterialPageRoute(builder: (context) => Lookup(
                                      title: "Lokasi Kamar", 
                                      datamodel: new Lokasi(widget.session,param: paramlokasi()), )
                                    ),              
                              );
                  
                  setState(() {
                      if(result != null) {
                        kodeLokasi = result["ID"];
                        namaLokasi = result["Title"];
                        //_fetchStandar(_kodeItemFG);
                      }
                      
                  });

                },                
              )
            ],
          ),

          // Status Tahanan

          ExpansionTile(
            initiallyExpanded: true,
            title: Text("Status Tahanan ", style: TextStyle(color: Theme.of(context).primaryColorDark),),
            children: [
              ListTile(
                leading: Switch(
                  value: statusTahanan.toString() == "0" ? false : true , 
                  onChanged: (v){
                    if(v){
                      statusTahanan = 1;
                    }
                    else{
                      statusTahanan = 0;
                    }
                    setState(() {});
                    print(statusTahanan);
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
  Widget _inputDataNumeric({
                    String title, 
                    String label,    
                    String caption="",                
                    dynamic dataField, 
                    String uom="",
                    String description="",
                    double min = 0,
                    double max = 0,
                    double valid = 0,
                    void Function(dynamic value) onChange}) {

    return ListTile( 
        contentPadding: const EdgeInsets.only(left: 0),
        subtitle: caption == '' ? null : Text("$caption", style: TextStyle(color: Colors.black38, fontWeight: FontWeight.bold),),
        leading: Container(
            height: 30, 
            width: 100, 
            child: Center(child: Text("$dataField",style: TextStyle(
              fontSize: 16, 
              fontWeight: FontWeight.bold)
            ))
        ),
        onTap: () async{
            var data = await inputNumeric(
              context: context, 
              title: "$title",
              label: "$label", 
              data:dataField,
              description: "$description",
              uom: "$uom"
            );
            if(data != null) {
              onChange(data);
            }
        },
    );
  }
}