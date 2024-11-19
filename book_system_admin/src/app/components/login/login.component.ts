import { Component } from '@angular/core';
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {ComponentService} from "../component.service";

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent {
  loginForm: FormGroup;
  submitted = false;
  fieldTextType: boolean = false;

  constructor(
    private fb: FormBuilder,
    private componentService : ComponentService
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

    this.componentService.login(formData).subscribe({
      next:(response:any)=>{
        console.log('Login Successful:', formData);
      },error:(error : any) =>{
        console.log('Login Unsuccessful:');
      }
    });
  }
}
