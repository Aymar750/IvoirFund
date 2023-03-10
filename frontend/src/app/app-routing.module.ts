import { NgModule, Component } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { HomeComponent } from './Components/home/home.component';
import { ProjetsComponent } from './Components/pages/projets/projets.component';

const routes: Routes = [
  { path: '',redirectTo:'accueil', pathMatch: 'full' },
  { path: 'accueil', component: HomeComponent },
  { path: 'projets', component: ProjetsComponent },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
