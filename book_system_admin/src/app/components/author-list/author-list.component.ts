import { Component } from '@angular/core';
import {FormBuilder, FormGroup} from "@angular/forms";
import {ComponentService} from "../component.service";
import {NgxSpinnerService} from "ngx-spinner";
import {ToastrService} from "ngx-toastr";

@Component({
  selector: 'app-author-list',
  templateUrl: './author-list.component.html',
  styleUrls: ['./author-list.component.scss']
})
export class AuthorListComponent {
  filterForm !: FormGroup;
  tableData:any;
  totalRecords: number = 0;
  page = 1;
  pageSize = 10;
  constructor(
    private formBuilder: FormBuilder,
    private componentService : ComponentService,
    private spinner: NgxSpinnerService,
    private toastr: ToastrService,
  )
  {
    this.initializeFilterForm();
  }

  initializeFilterForm() {
    this.filterForm = this.formBuilder.group({
      keyword: [null],
      is_active: ['true']
    });
  }

  ngOnInit(): void {
    this._fetchData();
  }

  filterReset() {
    this.filterForm.reset();
    this.initializeFilterForm();
    this._fetchData();
  }

  _fetchData() {
    this.spinner.show();
    const formData = this.filterForm.value;

    formData.is_active = formData.is_active == 'true';
    this.componentService.getAuthorList(formData,this.page,this.pageSize).subscribe({
      next:(response:any)=>{
        this.tableData = response.all_author;
        console.log(this.tableData);
        this.totalRecords = response.totalRecords;
        this.spinner.hide();
      },error:(error : any) =>{
        this.spinner.hide();
        this.toastr.error('Something went wrong!', 'Error');
      }
    });
  }

  onPageChange = (pageNumber: number) => {
    this.page = pageNumber;
    this._fetchData();
  }

  statusChange(row: any) {
    const data = {
      author_ref: row.user_ref,
      is_active: !row.is_active,
    }
    this.spinner.show();
    this.componentService.getAuthorStatusChange(data).subscribe({
      next:(response:any)=>{
        this._fetchData();
        this.spinner.hide();
        this.toastr.success('Status change successfully','Success')
      },error:(error : any) =>{
        this.spinner.hide();
        this.toastr.error('Something went wrong!', 'Error');
      }
    });
  }

}
