using UnityEngine;
using System.Collections;
using UnityEngine.UI;

public class cameraMove : MonoBehaviour {

	public float cameraMovementSpeed = 0.02f;
	public float variavelEmpirica = 1.68f;
	public float x  = 0.0f;
	public float z  = 0.0f;

	public float tempoCalibracao = 5f;
	public bool calibra = true;
	FloatFilter magneticFilter = new AngleFilter(10);

	float h;
	float v;
	Vector3 direction;

	public Gerente gerente;
	public GeoPosicionamento geo;

	Transform target;
	public float distance;
	public bool usaPosRelativaCamera = true;
	private Quaternion rotacaoInicialCamera = Quaternion.identity;
	private bool pegarPrimeiroValor = false;
	
	//o motivo de ter um testePOIPC aqui é por que no gerente ele é desligado após o inicio do programa
	public bool testePOIPC = false; 

	//testes
	public Text xRot;
	public Text zRot;
    public Text nRot;
    public Text xPos;
	public Text zPos;
	public Text lat;
	public Text lon;
	public Text latIni;
	public Text lonIni;
	bool forca = false;

	void Start () {
		//encontra o gerente
		if (gerente == null)
			gerente = GameObject.Find ("Gerente").GetComponent<Gerente> ();

		//força o plugin a usar o compasso
		SensorHelper.TryForceRotationFallback(RotationFallbackType.MagneticField);

		target = this.transform;

		if(distance == 0)
			distance = (transform.position - target.position).magnitude;

		//já se organiza
		if(usaPosRelativaCamera)
			rotacaoInicialCamera = Quaternion.Euler(0,transform.rotation.eulerAngles.y,0);
		else
			rotacaoInicialCamera = Quaternion.identity;

		//inicia o plugin Gyrodroid
		SensorHelper.ActivateRotation();

		//iniciando os sensores
		Sensor.Activate(Sensor.Type.MagneticField);
		Sensor.Activate(Sensor.Type.Accelerometer);

		//inicia o uso dos sensores
		Debug.Log ("calibra "+calibra);
		StartCoroutine(CalibraSensores());
		StartCoroutine(calibraComABussula());
	}

	IEnumerator CalibraSensores(){
		pegarPrimeiroValor = false;

		while(!SensorHelper.gotFirstValue) {
			SensorHelper.FetchValue();
			yield return null;
		}

		SensorHelper.FetchValue();

		yield return new WaitForSeconds(0.1f);

		//inicializa os valores da rotação
		Quaternion initialSensorRotation = SensorHelper.rotation;
		rotacaoInicialCamera *= Quaternion.Euler(0,-initialSensorRotation.eulerAngles.y,0);

		//para liberar os updates
		pegarPrimeiroValor = true;
	}

	//para garantir que o loop do update só comece depois que os dados dos sensores forem coletados
	void LateUpdate(){
		if (!testePOIPC) {//aqui é quando não estiver sendo realizado testes no pc
			//sai se por um acaso ele entrar aqui primeiro
			if (usaPosRelativaCamera) {
				if (!pegarPrimeiroValor) {
					return;
				}
			}

			//não faça nada se não tiver target
			if (target == null) {
				return;
			}

			transform.rotation = rotacaoInicialCamera * SensorHelper.rotation;
			transform.position = target.position - transform.forward * distance;	
		}
	}


	void Update() {

        //controle de personagem no PC
        if (testePOIPC) {
			h = Input.GetAxis ("Horizontal");
			v = Input.GetAxis ("Vertical");

			direction = new Vector3 (h, 0, v);	

			//controle de rotaÃ§ao - isso independe de plataforma
			if (Input.GetKey (KeyCode.LeftArrow)) {
				this.transform.Rotate (Vector3.up, Time.deltaTime * -40f);
			}
			if (Input.GetKey (KeyCode.RightArrow)) {
				this.transform.Rotate (Vector3.up, Time.deltaTime * 40f);
			}

			if (v != 0f) {
				if (Input.GetKey (KeyCode.UpArrow)) {
					this.transform.Translate (Vector3.forward * 0.5f);
				}
				if (Input.GetKey (KeyCode.DownArrow)) {
					this.transform.Translate (Vector3.forward * -0.5f);
				}
			}
			x =	gerente.convertePos (geo.longitudeInicial, geo.longitudeAtual);
			z = gerente.convertePos (geo.latidudeInicial, geo.latidudeAtual);

            atualizaUI();

		} else {
			//então não é um teste no PC e estamos no mobile com sensor de GPS
			if (calibra == false) {//se não estiver calibrando pode sim se movimentar
				x =	gerente.convertePos (geo.longitudeInicial, geo.longitudeAtual);
				z = gerente.convertePos (geo.latidudeInicial, geo.latidudeAtual);

				this.transform.position = Vector3.Lerp (transform.position, new Vector3 (x, 2, z), Time.deltaTime * cameraMovementSpeed);

				atualizaUI ();
			}
        }
			
		//calibração do norte
		if (calibra == true) {
			transform.rotation = Quaternion.Euler(0,magneticFilter.Update(Sensor.GetOrientation().y),0);
			gerente.transform.rotation = this.transform.rotation;
		}

	}


	//calibração forçada
	IEnumerator calibraComABussula(){
		//o objetivo aki é fazer com quer o update funcione pelo tempo de calibração
		yield return new WaitForSeconds(tempoCalibracao);
		Debug.Log ("passei pelo tempo de calibração");
		calibra = false;
		Debug.Log ("calibra "+calibra);
	}


    public void atualizaUI(){
        //atualiza UI PN CameraPos
        xPos.text = "" + x;
        zPos.text = "" + z;
        xRot.text = "" + this.transform.rotation.x;
        zRot.text = "" + this.transform.rotation.z;
        lat.text = "" + geo.latidudeAtual;
        lon.text = "" + geo.longitudeAtual;
        latIni.text = "" + geo.latidudeInicial;
        lonIni.text = "" + geo.longitudeInicial;

        nRot.text = -Input.compass.magneticHeading + "";
    }



}
