import { Component } from '@angular/core';
import {FormBuilder, FormControl, FormGroup, Validators} from "@angular/forms";
import {ComponentService} from "../component.service";
import {Router} from "@angular/router";
import {NgxSpinnerService} from "ngx-spinner";
import {ToastrService} from "ngx-toastr";

@Component({
  selector: 'app-registration',
  templateUrl: './registration.component.html',
  styleUrls: ['./registration.component.scss']
})
export class RegistrationComponent {

  registrationForm: FormGroup;

  constructor(
    private fb : FormBuilder,
    private componentService : ComponentService,
    private router: Router,
    private spinner: NgxSpinnerService,
    private toastr: ToastrService,
  ) {

    this.registrationForm = this.fb.group({
      name: ['', Validators.required],
      email: ['', [Validators.required, Validators.email]],
      password: ['', [Validators.required, Validators.minLength(6)]],
      confirm_password: ['', Validators.required]
    }, {
      validators: this.passwordMatchValidator
    });
  }


  passwordMatchValidator(group: FormGroup): { [key: string]: boolean } | null {
    const password = group.get('password')?.value;
    const confirmPassword = group.get('confirm_password')?.value;
    return password === confirmPassword ? null : { 'mismatch': true };
  }

  onSubmit(): void {
    this.spinner.show();
    if (this.registrationForm.valid) {
      this.componentService.registration(this.registrationForm.value).subscribe({
        next : (response:any)=>{
          this.router.navigate(['/login']);
          this.registrationForm.reset();
          this.spinner.hide();
          this.toastr.success('Registration successfully','Success')
        },error:(error : any) =>{
          this.spinner.hide();
          this.toastr.error('The email has already been taken.!', 'Error');
        }
      });
    }
  }

}
