import { Component, OnInit } from '@angular/core';
import { AuthService } from 'src/app/shared/auth.service';

@Component({
  selector: 'app-dashcompte',
  templateUrl: './dashcompte.component.html',
  styleUrls: ['./dashcompte.component.css']
})

export class DashcompteComponent implements OnInit {
  nom: string | null = null;
 
  constructor(private authService : AuthService) { }
  ngOnInit(): void {
    const userString = localStorage.getItem('user');
    if(userString){
      const user = JSON.parse(userString);
      this.authService.getUserProfile(user.user_id).subscribe({
        next: (res) => {
            this.nom = res.user_name;
        }
      })
    }
  }
  
}
