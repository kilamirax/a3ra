using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class ObjetoA3RA : MonoBehaviour {
	
    public GameObject objetosRA;

	//a posição 0 é o POI, a 1 é um objeto 3d
    public List<GameObject> objetosRAPossiveis = new List<GameObject>();
    public string textoExibi;
    public List<Evento> eventos = new List<Evento>();
	public ObjetoMultimidia objetoMultimidia;

	public bool fuiAcionado = false; //após ser acionado ele se configura e volta a ser falso
	public bool acionado = false; //vai se manter sempre true quanfo for acionado
	public bool souInformativo = false;
	public bool souPOI = false;
	public bool souMarcador = false;
	//o objetivo do posso funcionár é que seu update só deve verificar o comportamento do objeto se o gerente já fez todas as configurações
	public bool souColisao = false;
	//quando se é marcador, se delega a outro objeto que será aumentado dizer que foi aumentado, se isso acontecer, ele tem que descer ao pai para
	//que ele também acione o gatilho
	public bool souFilhoDeMarcador = false;
	Gerente gerente;
	
    void Awake () {
		if (gerente == null)
			gerente = GameObject.Find ("Gerente").GetComponent<Gerente> ();
	}

	void Update() {
		if (fuiAcionado) {
			if (souPOI) {
				objetosRAPossiveis[0].SetActive (true);  // habilita o mapmaker

				fuiAcionado = false;
			}
			if (objetoMultimidia.idArquivo != "null") {
				this.objetosRA.SetActive (true);
				fuiAcionado = false;
			}
			if (souMarcador) {
				//o acionamento do objeto 3d é pelo gerente cloudreco
				fuiAcionado = false;
			}
			if (souInformativo) {
				gerente.acionaInformaObjTexto (this.gameObject, objetoMultimidia.textoObjeto);
				fuiAcionado = false;
			}
			if (this.gameObject.name == "Fim de Programa") {
				gerente.acionaInformaObjTexto (this.gameObject, "Você realizou todas as tarefas! Fim de programa");
			}
		}
	}

	public void acionaGatilho(){
		for (int i = 0; i < eventos.Count; i++) {
			eventos[i].gatilho.GetComponent<ObjetoA3RA> ().fuiAcionado = true;
			eventos[i].gatilho.GetComponent<ObjetoA3RA> ().acionado = true;

			if (souFilhoDeMarcador) {
				eventos[i].gatilho.GetComponent<ObjetoA3RA> ().acionaGatilho();
			}
		}
	}

	public bool tenhoAlgumEventoColisao(){
		bool resposta = false;
		for (int i = 0; i < eventos.Count; i++) {
			if(eventos[i].acao =="2"){
				resposta = true;
			}
		}
		return resposta;
	}

	void OnTriggerEnter(Collider g) {
		if (souColisao && acionado) {
			Debug.Log (g+"colidiu em mim, vou acionar meus gatilhos");
			acionaGatilho ();
		}
    }

}
