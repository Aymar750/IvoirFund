import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { CategorieService } from 'src/app/services/categorie.service';
import { Categories } from '../../../Interfaces/categories';
import { ProjetService } from '../../../services/projet.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-campagne',
  templateUrl: './campagne.component.html',
  styleUrls: ['./campagne.component.css']
})
export class CampagneComponent implements OnInit  {
  allCategories : Categories[] = [];

  // personalDetails!: FormGroup;
  // projetsDetails!: FormGroup;
  // campaignDetails!: FormGroup;
  form!: FormGroup;
  step=1;
  selectedFile!: File | null;
  selectedFiles: (File | null)[] = [null, null, null];
  formValues: any[] = [];

  constructor (private formBuilder:FormBuilder, 
    private categorieService: CategorieService,
    private projetService: ProjetService,
    public router: Router){}

  ngOnInit(){
    this.getCat();

    this.form = this.formBuilder.group({
      step1: this.formBuilder.group({
        name: ['', Validators.required],
        email: ['', Validators.required],
        phone: ['',Validators.required],
        web: [''],
        social: ['',Validators.required],
      }),
      step2: this.formBuilder.group({
        name: ['', Validators.required],
        description: ['', Validators.required],
        // file: ['',Validators.required],
        contre: ['', Validators.required],
        montant: ['', Validators.required],
        cat: [null],
      }),
      step3:this.formBuilder.group({
        datefin: ['', Validators.required],
        // budget: ['',Validators.required]
      })
    });
    // this.personalDetails = this.formBuilder.group({
    //   name: ['', Validators.required],
    //   email: ['', Validators.required],
    //   phone: ['',Validators.required],
    //   web: [''],
    //   social: ['',Validators.required],
    // });
    // this.projetsDetails = this.formBuilder.group({
    //   name: ['', Validators.required],
    //   description: ['', Validators.required],
    //   file: ['',Validators.required],
    //   contre: ['', Validators.required],
    //   montant: ['', Validators.required],
    //   cat: [null],
    // });
    // this.campaignDetails = this.formBuilder.group({
    //   datefin: ['', Validators.required],
    //   budget: ['',Validators.required]
    // });
  }
  projet(){
    this.projetService.createproject(this.form.value).subscribe((res) => {

      this.router.navigate(['/accueil'])
      
    })
  }

  getCat(){
    this.categorieService.getCategories().subscribe((data)=> {
      //console.log(data);
      
      this.allCategories = data;
    })
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
    
    const formGroup = this.form.get(`step${this.step}`) as FormGroup;
    if (formGroup.valid) {

    } else {
      formGroup.markAllAsTouched();
    }

    // Sauvegarder les fichiers déjà sélectionnés avant de passer à l'étape suivante
    if (this.selectedFiles[this.step - 1] != null) {
      this.formValues[this.step - 1].file = this.selectedFiles[this.step - 1];
    }

    this.step++;
    this.selectedFile = this.selectedFiles[this.step - 1];
}

  
  submit(){
    this.router.navigate(['/accueil'])
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




