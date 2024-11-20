import { Component } from '@angular/core';
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {ComponentService} from "../component.service";
import {NgbModal} from "@ng-bootstrap/ng-bootstrap";

@Component({
  selector: 'app-own-book-list',
  templateUrl: './own-book-list.component.html',
  styleUrls: ['./own-book-list.component.scss']
})
export class OwnBookListComponent {
  filterForm: FormGroup;
  tableData:any;
  totalRecords: number = 0;
  page = 1;
  pageSize = 10;
  coverImageFile: File | null = null;
  coverImagePreview: string | null = null;
  bookForm: FormGroup;
  isEditMode = false;
  editingRow: any = null;
  selectedFile: File | null = null;

  constructor(
      private fb: FormBuilder,
      private componentService : ComponentService,
      private modalService: NgbModal
  )
  {
    this.filterForm = this.fb.group({
      keyword: [null],
    });

    this.bookForm = this.fb.group({
      title: ['', Validators.required],
      description:['']
    });
  }

  ngOnInit(): void {
    this._fetchData();
  }

  filterReset() {
    this.filterForm.reset();
    this._fetchData();
  }

  _fetchData() {
    this.componentService.getBookListByAuthor(this.filterForm.value,this.page,this.pageSize).subscribe({
      next:(response:any)=>{
        this.tableData = response.all_books;
        this.totalRecords = response.totalRecords;
        console.log('data Successful');
      },error:(error : any) =>{
        console.log('data Unsuccessful:');
      }
    });
  }

  onPageChange = (pageNumber: number) => {
    this.page = pageNumber;
    this._fetchData();
  }

  deleteRow(book_ref: any) {
    this.componentService.deleteBook(book_ref).subscribe({
      next:(response:any)=>{
        this._fetchData();
        console.log('data Successful');
      },error:(error : any) =>{
        console.log('data Unsuccessful:');
      }
    })
  }

  onFileSelected(event: any): void {
    const file: File = event.target.files[0];
    if (file) {
      this.selectedFile = file;

      const reader = new FileReader();
      reader.onload = () => {
        this.coverImagePreview = reader.result as string;
      };
      reader.readAsDataURL(file);
    }
  }

  onSubmit(modal: any): void {
    if (!this.bookForm.valid) {
      return;
    }

    const formData = new FormData();

    Object.keys(this.bookForm.value).forEach((key) => {
      formData.append(key, this.bookForm.value[key]);
    });

    if (this.selectedFile) {
      formData.append('cover_image', this.selectedFile, this.selectedFile.name);
    }

    if (this.isEditMode && this.editingRow) {

      this.componentService.updateBook(this.editingRow.book_ref, formData).subscribe({
        next: (response: any) => {
          this._fetchData();
          modal.close();
          console.log('Book updated successfully');
        },
        error: (error: any) => {
          console.log('Update failed:', error);
        },
      });
    } else {
      this.componentService.createBook(formData).subscribe({
        next: (response: any) => {
          this._fetchData();
          modal.close();
          console.log('Book created successfully');
        },
        error: (error: any) => {
          console.log('Creation failed:', error);
        },
      });
    }
  }

  openModal(modal: any, row: any = null): void {
    this.isEditMode = !!row;

    if (this.isEditMode && row) {
      this.bookForm.patchValue(row);
      this.coverImagePreview = row.cover_image_url;
      this.editingRow = row;
    } else {
      this.bookForm.reset({ is_active: true });
      this.coverImagePreview = null;
      this.editingRow = null;
    }

    this.modalService.open(modal, { size: 'lg', backdrop: 'static' });
  }


}
