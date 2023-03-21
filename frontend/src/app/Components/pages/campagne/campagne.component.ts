import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';

@Component({
  selector: 'app-campagne',
  templateUrl: './campagne.component.html',
  styleUrls: ['./campagne.component.css']
})
export class CampagneComponent implements OnInit  {
  personalDetails!: FormGroup;
  projetsDetails!: FormGroup;
  campaignDetails!: FormGroup;
  step=1;
  selectedFile!: File | null;
  selectedFiles: (File | null)[] = [null, null, null];
  formValues: any[] = [];

  constructor (private formBuilder:FormBuilder){}

  ngOnInit(){
    this.personalDetails = this.formBuilder.group({
      name: ['', Validators.required],
      email: ['', Validators.required],
      phone: ['',Validators.required]
    });
    this.projetsDetails = this.formBuilder.group({
      name: ['', Validators.required],
      description: ['', Validators.required],
      file: ['',Validators.required]
    });
    this.campaignDetails = this.formBuilder.group({
      datefin: ['', Validators.required],
      budget: ['',Validators.required]
    });
  }
  onFileSelected(event: any) {
    const file: File = event.target.files[0];
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => {
      this.selectedFiles[this.step - 1] = file;
    };
  }
  
  
  next(){
    this.selectedFiles[this.step] = this.selectedFile;
    
    if(this.step==1){
      if (this.personalDetails.invalid) {
        return;
      }
      this.formValues[0] = this.personalDetails.value;
    }
    if(this.step==2){
      if (this.projetsDetails.invalid) {
        return;
      }
      this.formValues[1] = this.projetsDetails.value;
    }

    // Sauvegarder les fichiers déjà sélectionnés avant de passer à l'étape suivante
    if (this.selectedFiles[this.step - 1] != null) {
      this.formValues[this.step - 1].file = this.selectedFiles[this.step - 1];
    }

    this.step++;
    this.selectedFile = this.selectedFiles[this.step - 1];
    console.log(this.formValues[1]);
}

  
  submit(){
    if(this.step==3){
      if (this.campaignDetails.invalid) {
        return;
      }
      this.formValues[2] = this.campaignDetails.value;
    }
  }
  previous(){
    this.selectedFiles[this.step] = this.selectedFile;

    // Sauvegarder les fichiers déjà sélectionnés avant de passer à l'étape précédente
    if (this.selectedFiles[this.step - 1] != null) {
      this.formValues[this.step - 1].file = this.selectedFiles[this.step - 1];
    }

    this.step--;
    this.selectedFile = this.selectedFiles[this.step - 1];
}

  
  getPreviousValues(index: number){
    return this.formValues[index] || {};
  }
}




