import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';


@Injectable({
  providedIn: 'root'
})
export class CategorieService {
  headers = new HttpHeaders({ 'Content-Type': 'application/json' });
  constructor( private http : HttpClient) { }

  getCategories(){
    return this.http.get<any>('http://localhost:8000/categories/read.php');
  }
  //http://localhost:8000/categories/projectbycat.php
  getProjectsCountByCategory(): Observable<any> {
    return this.http.get<any>('http://localhost:8000/categories/projectbycat.php');
  }
}
