import { Component } from '@angular/core';
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {ComponentService} from "../component.service";
import {AuthService} from "../../auth.service";
import {Router} from "@angular/router";
import {NgxSpinnerService} from "ngx-spinner";
import {ToastrService} from "ngx-toastr";

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent {
  loginForm: FormGroup;
  submitted = false;

  constructor(
    private fb: FormBuilder,
    private componentService : ComponentService,
    private authService :AuthService,
    private router : Router,
    private spinner: NgxSpinnerService,
    private toastr: ToastrService,
  ) {
    this.loginForm = this.fb.group({
      email: [null, [Validators.required, Validators.email]],
      password: [null, [Validators.required]],
    });
  }

  onSubmit() {
    this.submitted = true;

    if (this.loginForm.invalid) {
      console.log('Form is invalid');
      return;
    }
    const formData = this.loginForm.value;

    this.spinner.show();
    this.componentService.login(formData).subscribe({
      next:(response:any)=>{
        localStorage.setItem('access_token', response.token);
        localStorage.setItem('userName', response.name);
        localStorage.setItem('key', response.key);
        this.authService.login(response.token);
        this.spinner.hide();
        this.router.navigate(['/home']);
        this.toastr.success('Login successfully','Success')
      },error:(error : any) =>{
        this.spinner.hide();
        this.toastr.error('Check your email & password!', 'Error');
      }
    });
  }
}
