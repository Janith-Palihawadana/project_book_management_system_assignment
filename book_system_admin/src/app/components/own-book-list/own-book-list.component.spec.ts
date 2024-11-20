import { ComponentFixture, TestBed } from '@angular/core/testing';

import { OwnBookListComponent } from './own-book-list.component';

describe('OwnBookListComponent', () => {
  let component: OwnBookListComponent;
  let fixture: ComponentFixture<OwnBookListComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [OwnBookListComponent]
    });
    fixture = TestBed.createComponent(OwnBookListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
