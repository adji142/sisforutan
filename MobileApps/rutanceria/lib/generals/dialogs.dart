import 'package:flutter/material.dart';

Future messageDialog({BuildContext context, String title, String message}) async {
    return showDialog<void>(
      context: context,
      barrierDismissible: false, // user must tap button!
      builder: (BuildContext context) {
        return AlertDialog(
          titlePadding: EdgeInsets.all(5),
          contentPadding: EdgeInsets.fromLTRB(5, 15, 5, 15),
          title: Container(
              width: double.infinity,
              height: 30,
              color: Theme.of(context).primaryColorDark,
              child: Center(child: Text(title, style: TextStyle(color: Theme.of(context).primaryColorLight),))
          ),
          content: SingleChildScrollView(
            child: ListBody(
              children: <Widget>[
                Center(child: Text(message)),
              ],
            ),
          ),
          actions: <Widget>[
            FlatButton(
              child: Text('Proses'),
              onPressed: () {
                Navigator.of(context).pop(true);
              },
            ),
            FlatButton(
              child: Text('Batal'),
              onPressed: () {
                Navigator.of(context).pop(false);
              },
            ),
          ],
        );
      },
    );
  }

  Future messageBox({BuildContext context, String title, String message}) async {
    return showDialog<void>(
      context: context,
      barrierDismissible: false, // user must tap button!
      builder: (BuildContext context) {
        return AlertDialog(
          titlePadding: EdgeInsets.all(5),
          contentPadding: EdgeInsets.fromLTRB(5, 15, 5, 15),
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
                  child: Center(child: Text(message)),
                ),
              ],
            ),
          ),
          actions: <Widget>[
            FlatButton(
              child: Text('Tutup'),
              onPressed: () {
                Navigator.of(context).pop();
              },
            ),
          ],
        );
      },
    );
  }

  