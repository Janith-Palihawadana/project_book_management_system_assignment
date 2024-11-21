import { Component } from '@angular/core';
import {AuthService} from "../../auth.service";
import {Router} from "@angular/router";
import {NgxSpinnerService} from "ngx-spinner";

@Component({
  selector: 'app-navigation-bar',
  templateUrl: './navigation-bar.component.html',
  styleUrls: ['./navigation-bar.component.scss']
})
export class NavigationBarComponent {

  role_key: string | null = null;

  constructor(private authService:AuthService ,
              private spinner: NgxSpinnerService) {
  }
  ngOnInit(): void {
    this.role_key = localStorage.getItem('key');
  }

  logout() {
    this.authService.logout();
  }
}
