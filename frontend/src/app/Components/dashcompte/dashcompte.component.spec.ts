import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DashcompteComponent } from './dashcompte.component';

describe('DashcompteComponent', () => {
  let component: DashcompteComponent;
  let fixture: ComponentFixture<DashcompteComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ DashcompteComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(DashcompteComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
