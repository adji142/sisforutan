import 'dart:async';
import 'dart:ffi';

import 'package:flutter/material.dart';
import 'package:rutanceria/daftarCheck.dart';
import 'package:rutanceria/daftarLokasi.dart';
import 'package:rutanceria/daftarTahanan.dart';
import 'package:rutanceria/models/login.dart';
import 'package:rutanceria/models/lokasi.dart';
import 'package:rutanceria/models/session.dart';

class Home extends StatefulWidget{
  final Session session;
  Home(this.session);

  @override
  _HomeState createState() => _HomeState();
}

class _HomeState extends State<Home> {
  int _short = 0;
  bool _searchMode = true;
  Icon _appIcon = Icon(Icons.search, size: 32.0,);
  TextEditingController _searchText = TextEditingController();

  List dataDrawer;

  Future<Map> _getDrawer() async{
    Map param(){
      return{
        'id' : this.widget.session.idUser.toString()
      };
    }
    var temp = await Login(this.widget.session, filterQuery: param()).getDrawer();
    return temp;
  }
  _fetchDrawer() async{
    var temp = await _getDrawer();
    dataDrawer = temp["data"].toList();
    setState(() => {});
  }
  @override
  void initState() {
    _fetchDrawer();
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    // TODO: implement build
    var width = MediaQuery.of(context).size.width / 100;
    var height = MediaQuery.of(context).size.height / 100;

    Map param(){
      return{
        'KodeLokasi'  : '',
        'Kriteria'    : _searchText.text.toString()
      };
    }
    return Scaffold(
      
      appBar: AppBar(
            title: _searchWidget(),
            actions: <Widget>[
              IconButton(
                icon: _appIcon,
                onPressed: () {
                  _searchMode = _searchMode ? false: true;
                  _searchText.text = "";
                  setState(() => _appIcon = _searchMode ? Icon(Icons.search) : Icon(Icons.close));                  
                },
              ),
            ],
      ),
      body: Container(
              child: FutureBuilder(
                future: Lokasi(widget.session, param: param()).getLokasi(),
                builder: (context, snapshot) {
                  if (snapshot.hasError) print(snapshot.error);
                  return snapshot.hasData
                      ? _itemData(snapshot.data["data"])
                      : new Center(
                            child: new CircularProgressIndicator(),
                        );
                },
              )
      ),
      drawer: Drawer(
        child: Column(
          children:<Widget>[
            UserAccountsDrawerHeader( 
                accountName: Text(this.widget.session.kodeUser, style: TextStyle(fontSize: 18),),
                accountEmail: Text("Rutan"),
                currentAccountPicture: CircleAvatar(child: Icon(Icons.person, size: 48,),),
                arrowColor: Theme.of(context).primaryColorLight,
                otherAccountsPictures: <Widget>[
                  
                ],
            ),
            Container(
              height: height * 30,
              child: ListView.builder(
                itemCount: dataDrawer == null ? 0 : dataDrawer.length,
                itemBuilder: (context, index){
                  // IconData(codePoint)
                  return ListTile(
                    title: Text(dataDrawer[index]["permissionname"],style: TextStyle(fontWeight: FontWeight.bold, fontSize: 16, color: Theme.of(context).primaryColorDark)),
                    leading: Icon(IconData(int.parse(dataDrawer[index]["MobileLogo"]), fontFamily: "MaterialIcons")),
                    onTap: (){
                      switch (dataDrawer[index]["id"].toString()) {
                        case "2" :
                          Navigator.of(context).push(MaterialPageRoute(builder: (context) => DaftarLokasi(this.widget.session)));
                          // print("navigation 2");
                          break;
                        case "3" :
                          Navigator.of(context).push(MaterialPageRoute(builder: (context) => DaftarTahanan(this.widget.session)));
                          break;
                      }
                    },
                  );
                }
              ),
            )
          ],
        ),
      ),
    );
  }

  Widget _searchWidget() {
    if(_searchMode) {
      return Text(this.widget.session.appName);
    }else {
      return (
        Container(
          color: Theme.of(context).primaryColorLight,
          child: Padding(
            padding: const EdgeInsets.all(8.0),
            child: TextField(
              controller: _searchText,
              autofocus: true,
              decoration: InputDecoration.collapsed(hintText: "Cari Data"),
              textInputAction: TextInputAction.search,
              onChanged: (value) => setState((){})
            ),
          )
        )
      );
    }
  }

  Widget _itemData(List list) {
    return RefreshIndicator(
          onRefresh: ()=> _refreshData(),
          child: ListView.builder(
          itemCount: list == null ? 0 : list.length,
          itemBuilder: (context, index) {
            return Card(
                      child: ListTile(
                        leading: Icon(Icons.widgets, color: Theme.of(context).primaryColor,),
                        title: Text(list[index]['NamaLokasi'],  style: TextStyle(
                                                                          color: Theme.of(context).primaryColorDark,
                                                                          fontWeight:FontWeight.bold
                                                                    ),
                        ),
                        subtitle: list[index]["AreaUmum"] == "1" ? Text("Dikunjungi " + list[index]["Jml"].toString() + " Orang") :  Text("Dihuni " + list[index]['Jml'].toString() + " Orang", style: TextStyle(fontWeight: FontWeight.bold, color: Colors.blue),),
                        trailing: Icon(Icons.arrow_forward),
                        // trailing: Column(
                        //   mainAxisAlignment: MainAxisAlignment.center,
                        //   children: <Widget>[                
                        //     Expanded(child: Text("SHIFT ${list[index]['KodeShift']}", style: TextStyle(fontWeight: FontWeight.bold),)),
                        //     // Expanded(child: Text("${DateFormat('dd/MM/yyyy hh:mm:ss').format(DateTime.parse(list[index]['TglTransaksi']))}", style: TextStyle(color: Theme.of(context).primaryColorDark))),
                        //     Expanded(child: Text(list[index]['NamaStatus'], style: TextStyle(fontWeight: FontWeight.bold, color: Colors.red),)),
                        // ],),
                        onTap: (){
                          Navigator.of(context).push(MaterialPageRoute(builder: (context) => DaftarCheck(this.widget.session,list[index]['NamaLokasi'],list[index]['AreaUmum'].toString() == "0" ? list[index]['KodeLokasi'] : "" )));
                        },
                      ),
                    );
          },
      ),
    );
  }

  Future _refreshData() async{
      setState((){});

      Completer<Null> completer = Completer<Null>();
      Future.delayed(Duration(seconds: 1)).then( (_) {
        completer.complete();
      });
      return completer.future;
  }
  
}