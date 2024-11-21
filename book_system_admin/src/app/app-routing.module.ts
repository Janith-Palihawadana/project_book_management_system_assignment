import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import {LoginComponent} from "./components/login/login.component";
import {RegistrationComponent} from "./components/registration/registration.component";
import {BookListComponent} from "./components/book-list/book-list.component";
import {OwnBookListComponent} from "./components/own-book-list/own-book-list.component";
import {AuthorListComponent} from "./components/author-list/author-list.component";
import {AuthGuard} from "./auth.guard";


const routes: Routes = [
  { path: '', redirectTo: 'home', pathMatch: 'full' },
  { path: 'login', component: LoginComponent },
  { path: 'register', component: RegistrationComponent },
  { path: 'home', component: BookListComponent},
  { path: 'authors', component: AuthorListComponent ,canActivate: [AuthGuard]},
  { path: 'own-books-list', component: OwnBookListComponent ,canActivate: [AuthGuard]},

];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
