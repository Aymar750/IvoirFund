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
  projectCountByCategory!: any[];
  constructor(private categorieService: CategorieService) { }
  ngOnInit(): void {
    this.getCat();

    this.getProjectCountByCategory();
    // this.getProjectByCat();
  }
  getProjectCountByCategory() {
    this.categorieService.getProjectsCountByCategory().subscribe((data)=> {
      this.projectCountByCategory = data;
    })
    throw new Error('Method not implemented.');
  }

  getCat(){
    this.categorieService.getCategories().subscribe((data)=> {
      console.log(data);
      
      this.allCategories = data;
    })
  }
  // getProjectByCat(){
  //   this.categorieService.getProjectsbyCat().subscribe((data)=> {
  //     console.log(data);
  //     this.projectCat = data;
  //   })
  // }
}