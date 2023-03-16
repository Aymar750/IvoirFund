import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class ProjetService {
  headers = new HttpHeaders({ 'Content-Type': 'application/json' });
  constructor(private http :HttpClient) { }

  getAllProjects(){
    return this.http.get<any>('http://localhost:8000/projets/read.php');
  }
}