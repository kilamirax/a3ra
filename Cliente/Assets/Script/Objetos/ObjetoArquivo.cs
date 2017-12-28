using UnityEngine;
using System.Collections;
using System.Collections.Generic;
using System.Xml.Serialization;
using System;

[Serializable]
public class ObjetoArquivo : System.Object {
	//{"idARQUIVOS":"2","nome":"Igreja+do+Milagre+de+Santarem.skp","endereco":"multimidia\/","extensao":"skp","data":"Sat, 04 Feb 17 12:09:39 +0000","USUARIOS_idUSUARIOS":"1","tamanho":"16309553"}
	public string idARQUIVOS = "";
	public string endereco = "";
	public string nome = "";
	public string extensao = "";
	public string data = "";
	public string USUARIOS_idUSUARIOS = "";
	public string tamanho = "";
}
