import { Component, OnInit } from '@angular/core';
import { Categories } from '../../Interfaces/categories';
import { CategorieService } from '../../services/categorie.service';

@Component({
  selector: 'app-categorie',
  templateUrl: './categorie.component.html',
  styleUrls: ['./categorie.component.css']
})
export class CategorieComponent implements OnInit {
  allCategories : Categories[] = [];
  constructor(private categorieService: CategorieService) { }
  ngOnInit(): void {
    this.getCat();
  }

  getCat(){
    this.categorieService.getCategories().subscribe((data)=> {
      console.log(data);
      
      this.allCategories = data;
    })
  }
}