import { Projects } from './../../Interfaces/projects';
import { Component, OnInit } from '@angular/core';
import { ProjetService } from '../../services/projet.service';


@Component({
  selector: 'app-projet',
  templateUrl: './projet.component.html',
  styleUrls: ['./projet.component.css']
})
export class ProjetComponent implements OnInit {

  projects: Projects[]= [];

  constructor(private projetService: ProjetService) { }
  ngOnInit(): void {
    this.getProjects();
 
    // throw new Error('Method not implemented.');
  }
 

  getProjects() {
    this.projetService.getAllProjects().subscribe((data) => {
    console.log(data);
    this.projects = data;})
  }
  getDaysBetweenDates(startDate: Date, endDate: Date): number {
    const start = new Date(startDate);
    const end = new Date(endDate);
    const millisecondsPerDay = 24 * 60 * 60 * 1000;
    const diff = Math.abs(end.getTime() - start.getTime());
    const days = Math.ceil(diff / millisecondsPerDay);
    return days;
  }
  formatNumber(amount: number): string {
    if (amount >= 1000000) {
      return (amount / 1000000) + ' millions';
    } else if (amount >= 1000) {
      return (amount / 1000) + ' milles';
    } else {
      return amount.toString();
    }
  }
  
  

}


