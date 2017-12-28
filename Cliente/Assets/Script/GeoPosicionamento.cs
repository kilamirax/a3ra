using UnityEngine;
using System.Collections;
using UnityEngine.UI;

public class GeoPosicionamento : MonoBehaviour {

	public float latidudeInicial = 0;
	public float longitudeInicial= 0;
	public float altiduteInicial= 0;
	public float latidudeAtual =0;
	public float longitudeAtual =0;
	public float altiduteAtual =0;
	public bool primeiraVez = true;
	public bool leituraContinua = true;
	public bool offline = false;
	public bool leituraRealizada = false;
	int cont = 0;

	Gerente gerente;

	//controle de movimentação
	public float ultimaLatidudeAtual =0;
	public float ultimaLongitudeAtual =0;
	public float ultimaAltiduteAtual =0;

	void Start (){
		//encontra o gerente
		if (gerente == null)
			gerente = GameObject.Find ("Gerente").GetComponent<Gerente> ();
	}

	void Update () {
		if (leituraContinua) {
			StartCoroutine(pos(3));
		}
	}

	IEnumerator pos(int tempo){

		leituraContinua = false;
		cont++;

		//primeiro checa se o GPS está funcionando
		if (!Input.location.isEnabledByUser) {
			this.gerente.insereTextoDebug ("Serviço de GPS não habilitado");
			offline = true;
			yield break;
		}

		if (primeiraVez) {
			//Começa o serviço
			Input.location.Start ();
		}

		//Espera o serviço inicializar
		int maxWait = 20;
		while (Input.location.status == LocationServiceStatus.Initializing && maxWait > 0){
			yield return new WaitForSeconds(tempo);
			maxWait--;
		}

		//se não inicializar depois de 20 segundos
		if (maxWait < 1){
					this.gerente.insereTextoDebug ("Tempo limite atingido");
			yield break;
		}

		//falha na conexão
		if (Input.location.status == LocationServiceStatus.Failed){
			this.gerente.insereTextoDebug ("Não foi possivel determinar a localização");
			yield break;
		}
		else{//acessou
			latidudeAtual = Input.location.lastData.latitude;
			longitudeAtual = Input.location.lastData.longitude;
			altiduteAtual = Input.location.lastData.altitude;

			verificaMovimentacao ();

			/*
			print("Location: " + Input.location.lastData.latitude + " " 
				+ Input.location.lastData.longitude + " " 
				+ Input.location.lastData.altitude + " " 
				+ Input.location.lastData.horizontalAccuracy + " " 
				+ Input.location.lastData.timestamp);
				*/

		}

		//na primeira vez que le os dados do gps ele guarda a posição inicial, ela que vai ser a referencia para a movimentação
		if (primeiraVez) {
			latidudeInicial = latidudeAtual;
			longitudeInicial = longitudeAtual;
			altiduteInicial = altiduteAtual;
			primeiraVez = false;
		}

		yield return new WaitForSeconds(tempo);
		leituraContinua = true;

	}

	//para não flodar muito as inforamções de debug, somente será exibido os dados do GPS se ouve alguma modificação de posição
	public void verificaMovimentacao(){
		if ((ultimaLatidudeAtual != latidudeAtual) || 
			(ultimaLongitudeAtual != longitudeAtual) || 
			(ultimaAltiduteAtual != altiduteAtual)) {

			ultimaLatidudeAtual = latidudeAtual;
			ultimaLongitudeAtual = longitudeAtual; 
			ultimaAltiduteAtual = altiduteAtual;

			string t = "atualizei" + cont + "lat" + latidudeAtual+", "+  "lon" + longitudeAtual;
			this.gerente.insereTextoDebug (t);

			this.GetComponent<EnviaDadosServidor> ().latidude.text = ""+ultimaLatidudeAtual;
			this.GetComponent<EnviaDadosServidor> ().longitude.text = ""+ultimaLongitudeAtual;
		}
	}

}
