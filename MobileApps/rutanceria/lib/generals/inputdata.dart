import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:flutter/rendering.dart';
import 'package:rutanceria/generals/lookup.dart';
import 'package:rutanceria/models/session.dart';

Future inputNumeric({BuildContext context, String title="Input Data", String label="", String description = "", double data, String uom=""}) async {

    TextEditingController _input = TextEditingController();

    _input.text= data == 0.0 ? "" : data.toString();

    return showDialog<void>(
      context: context,
      barrierDismissible: false, // user must tap button!
      builder: (BuildContext context) {
        return AlertDialog(
          titlePadding: EdgeInsets.all(5),
          contentPadding: EdgeInsets.fromLTRB(1, 15, 1, 15),
          title: Container(
              width: double.infinity,
              height: 30,
              color: Theme.of(context).primaryColorDark,
              child: Center(child: Text(title, style: TextStyle(color: Theme.of(context).primaryColorLight),))
          ),
          content: SingleChildScrollView(
            child: ListBody(
              children: <Widget>[
                
                  Padding(
                    padding: const EdgeInsets.all(15),
                    child: TextField( 
                      autofocus: true,
                      controller: _input,
                      keyboardType: TextInputType.number,
                      textAlign: TextAlign.start,
                      textInputAction: TextInputAction.done,
                      decoration: InputDecoration(
                          border: OutlineInputBorder(borderRadius: BorderRadius.circular(10)),
                          suffixText: uom,                          
                          suffixStyle: TextStyle(color: Theme.of(context).primaryColorDark, fontWeight: FontWeight.bold, fontSize: 18),
                          labelText: "$label",
                          labelStyle: TextStyle(color: Theme.of(context).primaryColorDark, fontWeight: FontWeight.bold, fontSize: 18),
                      ),
                    ),
                  ),

                  Padding(
                    padding: const EdgeInsets.only(left: 25, right: 25),
                    child: Text(description, style: TextStyle(fontSize: 14, color: Theme.of(context).primaryColorDark),),
                  )

              ],
            ),
          ),
          actions: <Widget>[
            FlatButton(
              child: Text('Proses'),
              onPressed: () {
                Navigator.of(context).pop(double.parse(_input.text));
              },
            ),
            FlatButton(
              child: Text('Batal'),
              onPressed: () {
                Navigator.of(context).pop(null);
              },
            ),
          ],
        );
      },
    );
 }

 Future inputNumericEx({BuildContext context, String title="Input Data", String label="", String labelEx="", String description = "", double data, String dataEx, String uom=""}) async {

    TextEditingController _input = TextEditingController();
    TextEditingController _inputEx = TextEditingController();

    _input.text = data == 0.0 ? "" : data.toString();
    _inputEx.text = dataEx.toString();

    return showDialog<void>(
      context: context,
      barrierDismissible: false, // user must tap button!
      builder: (BuildContext context) {
        return AlertDialog(
          titlePadding: EdgeInsets.all(5),
          contentPadding: EdgeInsets.fromLTRB(1, 15, 1, 15),
          title: Container(
              width: double.infinity,
              height: 30,
              color: Theme.of(context).primaryColorDark,
              child: Center(child: Text(title, style: TextStyle(color: Theme.of(context).primaryColorLight),))
          ),
          content: SingleChildScrollView(
            child: ListBody(
              children: <Widget>[
                
                  Padding(
                    padding: const EdgeInsets.all(15),
                    child: TextField( 
                      autofocus: true,
                      controller: _input,
                      keyboardType: TextInputType.number,
                      textAlign: TextAlign.start,
                      textInputAction: TextInputAction.next,
                      decoration: InputDecoration(
                          border: OutlineInputBorder(borderRadius: BorderRadius.circular(10)),
                          suffixText: uom,                          
                          suffixStyle: TextStyle(color: Theme.of(context).primaryColorDark, fontWeight: FontWeight.bold, fontSize: 18),
                          labelText: "$label",
                          labelStyle: TextStyle(color: Theme.of(context).primaryColorDark, fontWeight: FontWeight.bold, fontSize: 18),
                      ),
                    ),
                  ),

                  Padding(
                    padding: const EdgeInsets.only(left: 25, right: 25),
                    child: Text(description, style: TextStyle(fontSize: 14, color: Theme.of(context).primaryColorDark),),
                  ),

                  Padding(
                    padding: const EdgeInsets.all(15),
                    child: TextField( 
                      controller: _inputEx,
                      textAlign: TextAlign.start,
                      textInputAction: TextInputAction.done,
                      decoration: InputDecoration(
                          border: OutlineInputBorder(borderRadius: BorderRadius.circular(10)),
                          labelText: "$labelEx",
                          labelStyle: TextStyle(color: Theme.of(context).primaryColorDark, fontWeight: FontWeight.bold, fontSize: 18),
                      ),
                    ),
                  ),

              ],
            ),
          ),
          actions: <Widget>[
            FlatButton(
              child: Text('Proses'),
              onPressed: () {
                Navigator.of(context).pop(
                  {
                    "data": double.parse(_input.text),
                    "dataEx" : _inputEx.text
                  }
                );  
              },
            ),
            FlatButton(
              child: Text('Batal'),
              onPressed: () {
                Navigator.of(context).pop(null);
              },
            ),
          ],
        );
      },
    );
 }

 Future inputString({BuildContext context, String title="Input Data", String label="", String description = "", String data}) async {

    TextEditingController _input = TextEditingController();

    _input.text= data == "-" ? "" : data;

    return showDialog<void>(
      context: context,
      barrierDismissible: false, // user must tap button!
      builder: (BuildContext context) {
        return AlertDialog(
          titlePadding: EdgeInsets.all(5),
          contentPadding: EdgeInsets.fromLTRB(1, 15, 1, 15),
          title: Container(
              width: double.infinity,
              height: 30,
              color: Theme.of(context).primaryColorDark,
              child: Center(child: Text(title, style: TextStyle(color: Theme.of(context).primaryColorLight),))
          ),
          content: SingleChildScrollView(
            child: ListBody(
              children: <Widget>[
                
                  Padding(
                    padding: const EdgeInsets.all(15),
                    child: TextField( 
                      autofocus: true,
                      controller: _input,
                      textAlign: TextAlign.start,
                      textInputAction: TextInputAction.newline,
                      maxLines: 2,
                      decoration: InputDecoration(
                          border: OutlineInputBorder(borderRadius: BorderRadius.circular(10)),
                          labelText: "$label",
                          labelStyle: TextStyle(color: Theme.of(context).primaryColorDark, fontWeight: FontWeight.bold, fontSize: 18),
                      ),
                    ),
                  ),

                  Padding(
                    padding: const EdgeInsets.only(left: 25, right: 25),
                    child: Text(description, style: TextStyle(fontSize: 14, color: Theme.of(context).primaryColorDark),),
                  )

              ],
            ),
          ),
          actions: <Widget>[
            FlatButton(
              child: Text('Proses'),
              onPressed: () {
                Navigator.of(context).pop(_input.text);
              },
            ),
            FlatButton(
              child: Text('Batal'),
              onPressed: () {
                Navigator.of(context).pop(null);
              },
            ),
          ],
        );
      },
    );
 }

 class InputDaftarTimbang extends StatefulWidget {
   final String title;
   final String uom;
   final List data;
   final double min;
   final double max;

   InputDaftarTimbang({this.title="-", this.data,  this.min, this.max, this.uom=""});

   @override
   _InputDaftarTimbangState createState() => _InputDaftarTimbangState();
 }
 
 class _InputDaftarTimbangState extends State<InputDaftarTimbang> {

   List<TextEditingController> _data = List<TextEditingController>();
   List<bool> _status = List<bool>();

   int _selectCount;

   @override
   void initState() {

    for(int row=0; row < widget.data.length;row++) {
      _data.add(TextEditingController());
      _data[row].text= widget.data[row]["value"] == 0 ? '' : widget.data[row]["value"].toString();
      _status.add(widget.data[row]["status"]);     
    }

    super.initState();
  }

  @override
  void dispose() {
    super.dispose();
  }

   @override
   Widget build(BuildContext context) {

     print("REBUILD");

     _selectCount = 0;
     for(int row=0; row < _status.length;row++) {
      if(_status[row]) {
        _selectCount ++;
      }
    }

     return Scaffold(
       appBar: AppBar(
         title: Text("${widget.title}"),
         actions: <Widget>[           
           RaisedButton( 
             color: Theme.of(context).primaryColor,
             child: Text("Proses", style: TextStyle(color: Colors.white)),
             onPressed: () {

               List _newdata = List();
               for(int row=0; row < _data.length ;  row++) {
                 
                 if(_data[row].text=="") {
                   _data[row].text="0";
                 }

                 String _temp = '{"value":${double.parse(_data[row].text)}, "min":${widget.min}, "max":${widget.max}, "status":${_status[row]}}';
                 _newdata.add(_temp);
               }
               Navigator.pop(context, _newdata);

             },
           )
         ],
       ),

      bottomNavigationBar: new SizedBox(
        height: 55,
        child: Container(
          color: Theme.of(context).primaryColor,
          child: Center(child: Text("$_selectCount Check List", style: TextStyle(fontSize: 20, color: Colors.white)))
        ),
      ),

      
       body: Padding(
         padding: const EdgeInsets.all(8.0),
         child: ListView.builder(           
           itemCount: _data.length,
           itemBuilder: (context, index) {                  
                  return ListTile(
                      leading: CircleAvatar(
                        child: Text("${index+1}")
                      ),
                      trailing: Switch( 
                        activeColor: Colors.blue,
                        value: _status[index],
                        onChanged: (v) {
                          if(_data[index].text.trim()!="" || double.parse(_data[index].text) == 0) {  
                            setState(() {
                              _status[index]=v;  
                              print("Status Changed -> $v");
                            });
                          }
                        },
                      ),
                      title: TextField(                                                                         
                          controller: _data[index],
                          keyboardType: TextInputType.number,
                          decoration: InputDecoration(      
                            border: InputBorder.none,    
                            filled: true,       
                            fillColor: _getColorStatus(widget.min, widget.max, _data[index].text.trim() == "" ? 0 : double.parse(_data[index].text)),
                            suffixText: "${widget.uom}",
                            suffixStyle: TextStyle(color: Theme.of(context).primaryColorDark , fontSize: 20, fontWeight: FontWeight.bold)
                          ),
                          style: TextStyle(fontSize: 18),
                          onChanged: (v) {
                            setState(() {});
                          },
                        ),
                  );
           },
         )
         
       ),
     );
   }

  Color _getColorStatus(double min, double max, double value) {
      Color retColor = value < min && value > 0
                       ? Colors.yellow[100] : value > max 
                       ? Colors.red[100] : value == 0
                       ? Colors.grey[300] : Colors.blue[100];
      return retColor;  
  }


 }
 class InputDaftarLebarBenang extends StatefulWidget {
   final String title;
   final String uom;
   final List dataTimbang;
   final List data;
   final double min;
   final double max;

   InputDaftarLebarBenang({this.title="-", this.dataTimbang, this.data,  this.min, this.max, this.uom=""});

   @override
   _InputDaftarLebarBenangState createState() => _InputDaftarLebarBenangState();
 }
 
 class _InputDaftarLebarBenangState extends State<InputDaftarLebarBenang> {

   List<TextEditingController> _data = List<TextEditingController>();

   int _selectCount;

   @override
   void initState() {

    for(int row=0; row < widget.data.length;row++) {
      _data.add(TextEditingController());
      _data[row].text= widget.data[row]["value"] == 0 ? '' : widget.data[row]["value"].toString();
    }

    super.initState();
  }

  @override
  void dispose() {
    super.dispose();
  }

   @override
   Widget build(BuildContext context) {

     print("REBUILD");

    _selectCount = 0;
     for(int row=0; row < _data.length;row++) {
      if(_data[row].text.trim() != "" && double.parse(_data[row].text) != 00 ) {
        _selectCount ++;
      }
    }
     return Scaffold(
       appBar: AppBar(
         title: Text("${widget.title}"),
         actions: <Widget>[           
           RaisedButton( 
             color: Theme.of(context).primaryColor,
             child: Text("Proses", style: TextStyle(color: Colors.white)),
             onPressed: () {

               List _newdata = List();
               for(int row=0; row < _data.length ;  row++) {
                 
                 if(_data[row].text=="") {
                   _data[row].text="0";
                 }

                 String _temp = '{"value":${double.parse(_data[row].text)}, "min":${widget.min}, "max":${widget.max}, "status":false}';
                 _newdata.add(_temp);
               }
               Navigator.pop(context, _newdata);

             },
           )
         ],
       ),

      bottomNavigationBar: new SizedBox(
        height: 55,
        child: Container(
          color: Theme.of(context).primaryColor,
          child: Center(child: Text("$_selectCount Item", style: TextStyle(fontSize: 20, color: Colors.white)))
        ),
      ),

      
       body: Padding(
         padding: const EdgeInsets.all(8.0),
         child: ListView.builder(           
           itemCount: _data.length,
           itemBuilder: (context, index) {                  
                  return ListTile(
                      leading: CircleAvatar(
                        child: Text("${index+1}"),
                      ),
                      title: Container(
                        child: Row(
                          children: <Widget>[
                            //Expanded( 
                            //  flex: 1,
                            //  child: Container(
                            //    height: 47,
                            //    color: _getColorStatus(widget.dataTimbang[index]["min"], widget.dataTimbang[index]["max"], widget.dataTimbang[index]["value"]),
                            //    child: Center(child: Text("${widget.dataTimbang[index]["value"]} gr", style: TextStyle(fontSize: 18, color: widget.dataTimbang[index]["value"] == 0 ? Colors.grey[300] : Colors.black),))
                            //)),
                            //SizedBox(width: 10,),
                            Expanded(
                                flex: 2,
                                child: TextField(                                                                         
                                  controller: _data[index],
                                  keyboardType: TextInputType.number,
                                  decoration: InputDecoration(      
                                    border: InputBorder.none,    
                                    filled: true,  
                                    fillColor: _getColorStatus(widget.min, widget.max, _data[index].text.trim() == "" ? 0 : double.parse(_data[index].text)),
                                    //prefixText: "Lebar :  ",
                                    //prefixStyle: TextStyle(color: Theme.of(context).primaryColorDark, fontSize: 20, fontWeight: FontWeight.bold),
                                    suffixText: "${widget.uom}",
                                    suffixStyle: TextStyle(color: Theme.of(context).primaryColorDark , fontSize: 20, fontWeight: FontWeight.bold)
                                  ),
                                  style: TextStyle(fontSize: 18),
                                  onChanged: (v) {
                                    setState(() {
                                    });
                                  },
                                ),
                            ),
                          ],
                        ),
                      ),
                  );
           },
         )
         
       ),
     );
   }

  Color _getColorStatus(double min, double max, double value) {
      Color retColor = value < min && value > 0
                       ? Colors.yellow[100] : value > max 
                       ? Colors.red[100] : value == 0
                       ? Colors.grey[300] : Colors.blue[100];
      return retColor;  
  }

 }
 class InputUjiShringkage extends StatefulWidget{
   final String title;
   final List dataShringkage;
   final List dataTimbang;
   final Session session;
   InputUjiShringkage({
     this.title,
     this.dataShringkage,
     this.dataTimbang,
     this.session
   });

   @override
   _inputUjiShringkage createState() => _inputUjiShringkage();
 }
 class _inputUjiShringkage extends State<InputUjiShringkage>{
   List<TextEditingController> _dataShringkage = List<TextEditingController>();
   List<TextEditingController> _standar = List<TextEditingController>();
   List<TextEditingController> _hasil = List<TextEditingController>();
   List _sample = List();
   List<String> _sample_Double = List<String>();
   String _xjson = "[";
   @override
   void initState() {
    for(int row = 0; row < 4;row++){
      _dataShringkage.add(TextEditingController());
      _standar.add(TextEditingController());
      _hasil.add(TextEditingController());

      _dataShringkage[row].text= widget.dataShringkage[row]["sample"] == 0 ? '0.00':widget.dataShringkage[row]["sample"].toString();
      _standar[row].text= widget.dataShringkage[row]["standar"] == 0 ? '0.00':widget.dataShringkage[row]["standar"].toString();
      _hasil[row].text= widget.dataShringkage[row]["hasil"] == 0 ? '0.00':widget.dataShringkage[row]["hasil"].toString();

    }

    for(int row = 0;row< widget.dataTimbang.length;row++){
      if(row+1 == widget.dataTimbang.length){
        _xjson += '{"ID":"$row","Title":"${double.parse(widget.dataTimbang[row].toString())}"}]';
      }
      else{
        _xjson += '{"ID":"$row","Title":"${double.parse(widget.dataTimbang[row].toString())}"},';
      }
      // _sample.add(xjson);
      _sample_Double.add(widget.dataTimbang[row].toString());
    }
    var sisa = 4 - _sample_Double.length;
    if(sisa <4){
        for(int row = 0; row < sisa;row++){
        // _sample.add(xjson);
        _sample_Double.add("0");
        }
      }
    print(json.decode(_xjson));
    super.initState();
  }
  @override
    void dispose() {
      super.dispose();
    }
  @override
  Widget build(BuildContext context){
    print("rebuild");
      return Scaffold(
        appBar: AppBar(
         title: Text("${widget.title}"),
         actions: <Widget>[           
           RaisedButton( 
             color: Theme.of(context).primaryColor,
             child: Text("Proses", style: TextStyle(color: Colors.white)),
             onPressed: () {

               List _newdata = List();
               String temp;
               for(int row=0; row < 4;  row++) {
                 String temp = '{"sample":${double.parse(_sample_Double[row])},"standar":${_standar[row].text},"hasil":"${_hasil[row].text}"}';
                 print(temp);
                 _newdata.add(temp);
               }
               Navigator.pop(context, _newdata);
             },
           )
         ],
       ),
       body: Padding(
        padding: const EdgeInsets.fromLTRB(5, 15, 0, 5),
        child: ListView.builder(
          itemCount: 4,
          itemBuilder: (context, index){
            return ExpansionTile(
              title: ListTile(
                leading: CircleAvatar(child: Text("${index+1}"),),
                title: Text("Uji Shringkage Ke - ${index+1}"),
              ),
              children: <Widget>[
                Padding(
                   padding: const EdgeInsets.only(left: 70, right: 25),
                   child: ListTile(
                     leading: Text("Sample",style: TextStyle(color: Theme.of(context).primaryColorDark, fontWeight: FontWeight.bold),),
                     title: Text("", style: TextStyle(color: Theme.of(context).primaryColorDark),),
                     subtitle: double.parse(_sample_Double[index].toString())==0 || _sample_Double.length < 0
                              ? Text("<PILIH SAMPLE>", style: TextStyle(color: Colors.red))
                              : Text(_sample_Double[index].toString(), style: TextStyle(fontSize: 32, color: Colors.black, fontWeight: FontWeight.bold),),
                     trailing: Icon(Icons.keyboard_arrow_right, color: Theme.of(context).primaryColor,),
                     onTap: () async{
                      //  var result = await Navigator.push(context, 
                      //         MaterialPageRoute(builder: (context) => Lookup(
                      //           title: "SAMPLE PRODUK", 
                      //           datamodel: new Sample(_xjson), )
                      //         ),              
                      //   );
                      //   setState(() {
                      //       if(result != null) {
                      //         _sample_Double[index] = result["Title"];
                      //       }
                      //   });
                     },
                   )
                 ),
                 Padding(
                   padding: const EdgeInsets.only(left: 70, right: 25),
                   child: ListTile(
                     title: TextField(
                       controller: _standar[index],
                       keyboardType: TextInputType.number,
                       decoration: InputDecoration(
                              border: InputBorder.none,    
                              filled: true,  
                              icon: Container(width:85, child: Text("Standar", style: TextStyle(color: Theme.of(context).primaryColorDark, fontWeight: FontWeight.bold),))
                            ),
                        onChanged: (v){
                          setState(() {
                          });
                        },
                     ),
                   ),
                 ),
                 Padding(
                   padding: const EdgeInsets.only(left: 70, right: 25),
                   child: ListTile(
                     title: TextField(
                       controller: _hasil[index],
                       keyboardType: TextInputType.number,
                       decoration: InputDecoration(
                              border: InputBorder.none,    
                              filled: true,  
                              icon: Container(width:85, child: Text("Hasil", style: TextStyle(color: Theme.of(context).primaryColorDark, fontWeight: FontWeight.bold),))
                            ),
                        onChanged: (v){
                          setState(() {
                          });
                        },
                     ),
                   ),
                 ),
              ],
            );
          }
        )
       ),
      );
  }
 }
 class InputDaftarUjiFisik extends StatefulWidget{
   final String title;
   final List dataCekFisikBenang;
   final List dataTiter;
   final Session session;
   final String tanggal;
   final String item;
   final String mesin;
   final String shift;
   InputDaftarUjiFisik({
     this.title,
     this.dataCekFisikBenang,
     this.dataTiter,
     this.session,
     this.tanggal,
     this.item,
     this.mesin,
     this.shift
   });

  @override
  _InputDaftarUjiFisik createState() => _InputDaftarUjiFisik();
 }
 
  class _InputDaftarUjiFisik extends State<InputDaftarUjiFisik> {
    List<TextEditingController> _dataCekFisikBenang = List<TextEditingController>();
    List<bool> _kerapihan = List<bool>();
    List<TextEditingController> _keterangan = List<TextEditingController>();
    List<String> _status = List<String>();
    List<double> _titer = List<double>();
    String _kodeStatus = "";
    String _namaStatus = "";
    String _kodeStatusNOK = "" ;
    String _namaStatusNOK = "";
    // List<ListTile> _status = List<ListTile>();

    @override
    void initState() {
      for(int row = 0; row < widget.dataCekFisikBenang.length;row++ ){
        _dataCekFisikBenang.add(TextEditingController());
        _dataCekFisikBenang[row].text= widget.dataCekFisikBenang[row]["value"] == 0 ? '0.00':widget.dataCekFisikBenang[row]["value"].toString();
        _kerapihan.add(widget.dataCekFisikBenang[row]["kerapihan"]);
        _keterangan.add(TextEditingController());
        _keterangan[row].text = widget.dataCekFisikBenang[row]["keterangan"] == "" ? '' : widget.dataCekFisikBenang[row]["keterangan"].toString();
        _status.add(widget.dataCekFisikBenang[row]["status"]);
      }
      // generate data cekfisik
      super.initState();
    }

    @override
    void dispose() {
      super.dispose();
    }
    @override
    Widget build(BuildContext context){
      print("rebuild");
      return Scaffold(
        appBar: AppBar(
         title: Text("${widget.title}"),
         actions: <Widget>[           
           RaisedButton( 
             color: Theme.of(context).primaryColor,
             child: Text("Proses", style: TextStyle(color: Colors.white)),
             onPressed: () {

               List _newdata = List();
               String temp;
               for(int row=0; row < widget.dataCekFisikBenang.length;  row++) {
                 String temp = '{"value":${double.parse(_dataCekFisikBenang[row].text)},"kerapihan":${_kerapihan[row]},"keterangan":"${_keterangan[row].text}","status":"${_status[row].toString()}"}';
                 _newdata.add(temp);
               }
               Navigator.pop(context, _newdata);

             },
           )
         ],
       ),
       body: Padding(
         padding: const EdgeInsets.fromLTRB(5, 15, 0, 5),
         child: ListView.builder(
           itemCount: widget.dataCekFisikBenang.length,
           itemBuilder: (context, index){
             return ExpansionTile(
               initiallyExpanded: true,
               title: ListTile(
                 leading: CircleAvatar(child: Text("${index+1}"),),
                 title: Text("Droping Ke - ${index+1}"),
               ),
               children: <Widget>[
                 Padding(
                   padding: const EdgeInsets.only(left: 70, right: 25),
                   child: ListTile(
                     title: TextField(
                       controller: _dataCekFisikBenang[index],
                       keyboardType: TextInputType.number,
                       decoration: InputDecoration(
                              border: InputBorder.none,    
                              filled: true,  
                              icon: Container(width:85, child: Text("Diameter", style: TextStyle(color: Theme.of(context).primaryColorDark, fontWeight: FontWeight.bold),))
                            ),
                        onChanged: (v){
                          setState(() {
                          });
                        },
                     ),
                   ),
                 ),
                 Padding(
                   padding: const EdgeInsets.only(left: 70, right: 25),
                   child: ListTile(
                     title: Column(
                       children: <Widget>[
                         Row(
                           children: <Widget>[
                             Text("Kebersihan", style: TextStyle(color: Theme.of(context).primaryColorDark, fontWeight: FontWeight.bold),textAlign: TextAlign.left,),
                             Switch(
                                value: _kerapihan[index] == null ? false :_kerapihan[index],
                                //activeColor: Colors.blue,
                                onChanged: (v){
                                  if(widget.dataCekFisikBenang[index].toString()!="" || double.parse(widget.dataCekFisikBenang[index].text) == 0){
                                    _kerapihan[index] = v;
                                  }
                                },
                             )
                           ],
                         )
                       ],
                     )
                   ),
                 ),
                 Padding(
                   padding: const EdgeInsets.only(left: 70, right: 25),
                   child: ListTile(
                     title: TextField(
                       controller: _keterangan[index] == null ? "":_keterangan[index],
                       keyboardType: TextInputType.text,
                       decoration: InputDecoration(
                              border: InputBorder.none,    
                              filled: true,  
                              icon: Container(width:85, child: Text("Keterangan", style: TextStyle(color: Theme.of(context).primaryColorDark, fontWeight: FontWeight.bold),))
                            ),
                        onChanged: (v){
                          setState(() {
                          });
                        },
                     )
                   ),
                 ),
                 Padding(
                   padding: const EdgeInsets.only(left: 70, right: 25),
                   child: ListTile(
                     leading: Text("Status Produk",style: TextStyle(color: Theme.of(context).primaryColorDark, fontWeight: FontWeight.bold),),
                     title: Text("", style: TextStyle(color: Theme.of(context).primaryColorDark),),
                     subtitle: _status[index]=="" || _status[index]==""
                              ? Text("<PILIH STATUS>", style: TextStyle(color: Colors.red))
                              : Text(_status[index], style: TextStyle(fontSize: 32, color: _kodeStatus == "OK" ? Colors.black : Colors.red, fontWeight: FontWeight.bold),),
                     trailing: Icon(Icons.keyboard_arrow_right, color: Theme.of(context).primaryColor,),
                     onTap: () async{
                      //  var result = await Navigator.push(context, 
                      //         MaterialPageRoute(builder: (context) => Lookup(
                      //           title: "Status Produk", 
                      //           datamodel: new StatusQC(widget.session), )
                      //         ),              
                      //   );
                      //   setState(() {
                      //       if(result != null) {
                      //         _kodeStatus = result["ID"];
                      //         _namaStatus= result["Title"];
                      //         _status[index] = result["Title"];

                      //         if(_kodeStatus != "NOK") {
                      //           _kodeStatusNOK="";
                      //           _namaStatusNOK="";
                      //         }

                      //       }
                            
                      //   });
                     },
                   )
                 )
               ],
             );
           },
         ),
       )
      );
    }
    Widget _inputDataStatus() {
        return ListTile(
          leading: Text("Status Produk",style: TextStyle(color: Theme.of(context).primaryColorDark, fontWeight: FontWeight.bold),),
          title: Text("", style: TextStyle(color: Theme.of(context).primaryColorDark),),
          subtitle: _namaStatus == ""
                    ? Text("<PILIH STATUS>", style: TextStyle(color: Colors.red))
                    : Text(_namaStatus, style: TextStyle(fontSize: 32, color: _kodeStatus == "OK" ? Colors.black : Colors.red, fontWeight: FontWeight.bold),),
          trailing: Icon(Icons.keyboard_arrow_right, color: Theme.of(context).primaryColor,),
          onTap: () async{
            // var result = await Navigator.push(context, 
            //                   MaterialPageRoute(builder: (context) => Lookup(
            //                     title: "Status Produk", 
            //                     datamodel: new StatusQC(widget.session), )
            //                   ),              
            //             );
            
            // setState(() {
            //     if(result != null) {
            //       _kodeStatus = result["ID"];
            //       _namaStatus= result["Title"];

            //       if(_kodeStatus != "NOK") {
            //         _kodeStatusNOK="";
            //         _namaStatusNOK="";
            //       }

            //     }
                
            // });

          },                
        );
    }
  }
 class InputDaftarLab extends StatefulWidget {
   final String title;
   final String uom;
   final List dataTimbang;
   final List dataLebar;
   final List dataTebal;
   final List dataKuatTarik;
   final List dataElongation;
   final List dataTenacity;

   final List min;
   final List max;

   InputDaftarLab({
     this.title="-", 
     this.dataTimbang, 
     this.dataLebar,  
     this.dataTebal,
     this.dataKuatTarik,
     this.dataElongation,
     this.dataTenacity,
     this.min, 
     this.max, 
     this.uom=""
  });

   @override
   _InputDaftarLabState createState() => _InputDaftarLabState();
 }
 
 class _InputDaftarLabState extends State<InputDaftarLab> {

   List<TextEditingController> _dataTebal = List<TextEditingController>();
   List<TextEditingController> _dataKuatTarik = List<TextEditingController>();
   List<TextEditingController> _dataElongation = List<TextEditingController>();
   List<TextEditingController> _dataTenacity = List<TextEditingController>();

   
   int _selectCount;

   @override
   void initState() {
     print(widget.dataTimbang.length);
    for(int row=0; row < widget.dataTimbang.length;row++) {
      _dataTebal.add(TextEditingController());
      _dataKuatTarik.add(TextEditingController());
      _dataElongation.add(TextEditingController());
      _dataTenacity.add(TextEditingController());

      _dataTebal[row].text= widget.dataTebal[row]["value"] == 0 ? '' : widget.dataTebal[row]["value"].toString();
      _dataKuatTarik[row].text= widget.dataKuatTarik[row]["value"] == 0 ? '' : widget.dataKuatTarik[row]["value"].toString();
      _dataElongation[row].text= widget.dataElongation[row]["value"] == 0 ? '' : widget.dataElongation[row]["value"].toString();
      _dataTenacity[row].text= widget.dataTenacity[row]["value"] == 0 ? '' : widget.dataTenacity[row]["value"].toString();

    }

    super.initState();
  }

  @override
  void dispose() {
    super.dispose();
  }

   @override
   Widget build(BuildContext context) {

     print("REBUILD");

     _selectCount = 0;
     for(int row=0; row < widget.dataTimbang.length;row++) {
      if(widget.dataTimbang[row]["status"]) {
        _selectCount ++;
      }

    }

     return Scaffold(
       appBar: AppBar(
         title: Text("${widget.title}"),
         actions: <Widget>[           
           RaisedButton( 
             color: Theme.of(context).primaryColor,
             child: Text("Proses", style: TextStyle(color: Colors.white)),
             onPressed: () {

              List _newDataTebal = List();
              List _newDataKuatTarik = List();
              List _newDataElongation = List();
              List _newDataTenacity = List();

              String _temp;

              for(int row=0; row < widget.dataTimbang.length ;  row++) {
                 
                 if(_dataTebal[row].text=="") _dataTebal[row].text="0"; 
                 _temp = '{"value":${double.parse(_dataTebal[row].text)}, "min":${widget.min[0]}, "max":${widget.max[0]}, "status":false}';
                 _newDataTebal.add(_temp);

                 if(_dataKuatTarik[row].text=="") _dataKuatTarik[row].text="0";
                 _temp = '{"value":${double.parse(_dataKuatTarik[row].text)}, "min":${widget.min[1]}, "max":${widget.max[1]}, "status":false}';
                 _newDataKuatTarik.add(_temp);

                 if(_dataElongation[row].text=="") _dataElongation[row].text="0";
                 _temp = '{"value":${double.parse(_dataElongation[row].text)}, "min":${widget.min[2]}, "max":${widget.max[2]}, "status":false}';
                 _newDataElongation.add(_temp);

                 if(_dataTenacity[row].text=="") _dataTenacity[row].text="0";
                 _temp = '{"value":${double.parse(_dataTenacity[row].text)}, "min":${widget.min[3]}, "max":${widget.max[3]}, "status":false}';
                 _newDataTenacity.add(_temp);

               }

               Navigator.pop(context, [
                 _newDataTebal,
                 _newDataKuatTarik,
                 _newDataElongation,
                 _newDataTenacity
               ]);

             },
           )
         ],
       ),

      bottomNavigationBar: new SizedBox(
        height: 55,
        child: Container(
          color: Theme.of(context).primaryColor,
          child: Center(child: Text("$_selectCount Item Pengujian", style: TextStyle(fontSize: 20, color: Colors.white)))
        ),
      ),

      
       body: Padding(
         padding: const EdgeInsets.fromLTRB(5, 15, 0, 5),
         child: ListView.builder(           
           itemCount: widget.dataTimbang.length,
           itemBuilder: (context, index) {                  
                  return !widget.dataTimbang[index]["status"]
                  ? Container()
                  : ExpansionTile(
                    initiallyExpanded: true,
                    children: <Widget>[

                      Padding(
                        padding: const EdgeInsets.only(left: 70, right: 25),
                        child: ListTile(
                          title: TextField(
                            controller: _dataTebal[index],
                            keyboardType: TextInputType.number,
                            decoration: InputDecoration(
                              border: InputBorder.none,    
                              filled: true,  
                              fillColor: _getColorStatusLab(widget.min[0], widget.max[0], _dataTebal[index].text.trim() == "" ? 0 : double.parse(_dataTebal[index].text)),
                              icon: Container(width:85, child: Text("Tebal", style: TextStyle(color: Theme.of(context).primaryColorDark, fontWeight: FontWeight.bold),))
                            ),
                            onChanged: (v) {
                              setState(() {
                              });
                              
                            },
                          ),
                          trailing: Container(width:40, child: Text("mc", style: TextStyle(fontSize: 16, color: Colors.grey, fontWeight: FontWeight.bold),))
                        ),
                      ),

                      Padding(
                        padding: const EdgeInsets.only(left: 70, right: 25),
                        child: ListTile(
                          title: TextField(
                            controller: _dataKuatTarik[index],
                            keyboardType: TextInputType.number,
                            decoration: InputDecoration(
                              border: InputBorder.none,    
                              filled: true,  
                              fillColor: _getColorStatusLab(widget.min[1], widget.max[1], _dataKuatTarik[index].text.trim() == "" ? 0 : double.parse(_dataKuatTarik[index].text)),
                              icon: Container(width:85, child: Text("Kuat Tarik", style: TextStyle(color: Theme.of(context).primaryColorDark, fontWeight: FontWeight.bold),))
                            ),
                            onChanged: (v) {
                              setState(() {
                              });
                              
                            },
                          ),
                          trailing: Container(width:40, child: Text("kgf", style: TextStyle(fontSize: 16, color: Colors.grey, fontWeight: FontWeight.bold),))
                        ),
                      ),
                        Padding(
                        padding: const EdgeInsets.only(left: 70, right: 25),
                        child: ListTile(
                          title: TextField(
                            controller: _dataTenacity[index],
                            keyboardType: TextInputType.number,
                            decoration: InputDecoration(
                              border: InputBorder.none,    
                              filled: true,  
                              fillColor: _getColorStatusLab(widget.min[3], widget.max[3], _dataTenacity[index].text.trim() == "" ? 0 : double.parse(_dataTenacity[index].text)),
                              icon: Container(width:85, child: Text("Tenacity", style: TextStyle(color: Theme.of(context).primaryColorDark, fontWeight: FontWeight.bold),))
                            ),
                            onChanged: (v) {
                              setState(() {
                              });
                            }  
                            
                          ),
                          trailing: Container(width:40, child: Text("gr/d", style: TextStyle(fontSize: 16, color: Colors.grey, fontWeight: FontWeight.bold),))
                        ),
                      ),
                        Padding(
                        padding: const EdgeInsets.only(left: 70, right: 25),
                        child: ListTile(
                          title: TextField(
                            controller: _dataElongation[index],
                            keyboardType: TextInputType.number,
                            decoration: InputDecoration(
                              border: InputBorder.none,    
                              filled: true,  
                              fillColor: _getColorStatusLab(widget.min[2], widget.max[2], _dataElongation[index].text.trim() == "" ? 0 : double.parse(_dataElongation[index].text)),
                              icon: Container(width:85, child: Text("Elongation", style: TextStyle(color: Theme.of(context).primaryColorDark, fontWeight: FontWeight.bold),))
                            ),
                            onChanged: (v) {
                              setState(() {
                              });
                              
                            },
                          ),
                          trailing: Container(width:40, child: Text("%", style: TextStyle(fontSize: 18, color: Colors.grey, fontWeight: FontWeight.bold),))
                        ),
                      ),
                    ],
                    title: ListTile(
                        leading: CircleAvatar(
                          child: Text("${index+1}"),
                        ),
                        title: Container(
                          child: Row(
                            children: <Widget>[
                              Expanded( 
                                flex: 1,
                                child: Container(
                                  height: 47,
                                  color: _getColorStatus(widget.dataTimbang[index]["min"], widget.dataTimbang[index]["max"], widget.dataTimbang[index]["value"]),
                                  child: Center(child: Text("${widget.dataTimbang[index]["value"]} gr", style: TextStyle(fontSize: 18, color: widget.dataTimbang[index]["value"] == 0 ? Colors.grey[300] : Colors.black),))
                              )),
                              SizedBox(width: 10,),
                              Expanded( 
                                flex: 1,
                                child: Container(
                                  height: 47,
                                  color: _getColorStatus(widget.dataLebar[index]["min"], widget.dataLebar[index]["max"], widget.dataLebar[index]["value"]),
                                  child: Center(child: Text("${widget.dataLebar[index]["value"]} mm", style: TextStyle(fontSize: 18, color: widget.dataTimbang[index]["value"] == 0 ? Colors.grey[300] : Colors.black),))
                              )),
                            ],
                          ),
                        ),
                    ),
                  );
           },
         )
         
       ),
     );
   }

  Color _getColorStatus(double min, double max, double value) {
      Color retColor = value < min && value > 0
                       ? Colors.yellow[700] : value > max 
                       ? Colors.red[300] : value == 0
                       ? Colors.grey[300] : Colors.blue[300];
      return retColor;  
  }

  Color _getColorStatusLab(double min, double max, double value) {
      Color retColor = value < min && value > 0
                       ? Colors.yellow[100] : value > max 
                       ? Colors.red[100] : value == 0
                       ? Colors.grey[300] : Colors.blue[100];
      return retColor;  
  }

 }

 class InputDaftarUjiProduk extends StatefulWidget {
   final String title;
   final String uom;
   final List data;
   InputDaftarUjiProduk({this.title="-", this.data, this.uom=""});

   @override
   _InputDaftarUjiProdukState createState() => _InputDaftarUjiProdukState();
 }
 
 class _InputDaftarUjiProdukState extends State<InputDaftarTimbang> {

   List<TextEditingController> _data = List<TextEditingController>();

    @override
  void initState() {

    for(int row=0; row < widget.data.length;row++) {
      _data.add(TextEditingController());
      _data[_data.length-1].text= widget.data[row] == 0 ? '' : widget.data[row].toString();
    }

    super.initState();
  }

  @override
  void dispose() {
    print("Back To old Screen");
    super.dispose();
  }

   @override
   Widget build(BuildContext context) {
     return Scaffold(
       appBar: AppBar(
         title: Text("${widget.title}"),
         actions: <Widget>[
           RaisedButton( 
             color: Theme.of(context).primaryColor,
             child: Text("Proses", style: TextStyle(color: Colors.white)),
             onPressed: () {

               List _newdata = List();
               for(int row=0; row < _data.length ;  row++) {
                 if(_data[row].text=="") {
                   _data[row].text="0";
                 }

                 double _temp = double.parse(_data[row].text);
                 _newdata.add(_temp);
               }
               Navigator.pop(context, _newdata);

             },
           )
         ],
      ),
      floatingActionButton: FloatingActionButton(
        child: Icon(Icons.add),
        onPressed: () {
          setState(() {
                _data.add(TextEditingController());
                _data[_data.length-1].text="";  
          });
        },
      ),
       body: Padding(
         padding: const EdgeInsets.all(15.0),
         child: ListView.builder(           
           itemCount: _data.length,
           itemBuilder: (context, index) {                  
                  return ListTile(
                      leading: CircleAvatar(child: Text("${index+1}")),
                      trailing: IconButton( 
                        icon: Icon(Icons.close),
                        onPressed: (){
                          setState(() {
                            _data.removeAt(index);
                          });
                        },
                      ),
                      title: TextField( 
                        autofocus:  index==0 ? true: false,
                        controller: _data[index],
                        keyboardType: TextInputType.number,
                        textInputAction: TextInputAction.next,
                        decoration: InputDecoration(
                            //border: OutlineInputBorder(borderRadius: BorderRadius.circular(20)),
                            suffixText: "${widget.uom}",
                            suffixStyle: TextStyle(color: Theme.of(context).primaryColorDark , fontSize: 20, fontWeight: FontWeight.bold)
                        ),
                        style: TextStyle(fontSize: 18),
                      )
                  );
           },
         )
         
       ),
     );
   }
 }