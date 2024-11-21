import { Injectable } from '@angular/core';
import {Router} from "@angular/router";

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  constructor( private router : Router) { }

  isAuthenticated(): boolean {
    return !!localStorage.getItem('authToken');
  }

  login(token: string): void {
    localStorage.setItem('authToken', token);
  }

  logout(): void {
    this.router.navigate(['/login']);
    localStorage.clear();
  }
}
