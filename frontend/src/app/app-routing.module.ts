import { NgModule, Component } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { HomeComponent } from './Components/home/home.component';
import { ProjetsComponent } from './Components/pages/projets/projets.component';
import { LoginComponent } from './Components/pages/login/login.component';
import { RegisterComponent } from './Components/pages/register/register.component';
import { CompteComponent } from './Components/pages/compte/compte.component';
import { DashcompteComponent } from './Components/dashcompte/dashcompte.component';
import { NotifComponent } from './Components/pages/compte/notif/notif.component';
import { ProjetComponent } from './Components/pages/compte/projet/projet.component';
import { MessageComponent } from './Components/pages/compte/message/message.component';
import { ProfilComponent } from './Components/pages/compte/profil/profil.component';
import { AuthGuard } from './shared/auth.guard';
import { CampagneComponent } from './Components/pages/campagne/campagne.component';

const routes: Routes = [
  { path: '',redirectTo:'accueil', pathMatch: 'full' },
  { path: 'accueil', component: HomeComponent },
  { path: 'projets', component: ProjetsComponent },
  { path: 'login', component: LoginComponent},
  { path: 'register', component: RegisterComponent},
  { path: 'campaign', component: CampagneComponent},
  { path: 'compte', component: CompteComponent,
  children: [
    { path: 'tableauBord', component: DashcompteComponent , canActivate: [AuthGuard]},
    { path: 'notifications', component: NotifComponent , canActivate: [AuthGuard]},
    { path: 'mes-projets', component: ProjetComponent , canActivate: [AuthGuard]},
    { path: 'messages', component: MessageComponent , canActivate: [AuthGuard]},
    { path: 'mon-profil', component: ProfilComponent , canActivate: [AuthGuard]},
    { path: '',redirectTo:'tableauBord', pathMatch: 'full' },
  ]
},

];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
