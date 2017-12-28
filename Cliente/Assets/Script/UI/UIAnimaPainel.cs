using UnityEngine;
using System.Collections;

public class UIAnimaPainel : MonoBehaviour {

	private Animator anim;	

	void Start () {
		anim = GetComponent<Animator>();	
	}
	void Update () {}

	public void sai(){
		anim.SetBool ("sai", false);
	}
	public void Entra(){
		anim.SetBool ("entra", true);
	}

}
