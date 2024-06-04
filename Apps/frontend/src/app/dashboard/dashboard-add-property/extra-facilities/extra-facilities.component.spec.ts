import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ExtraFacilitiesComponent } from './extra-facilities.component';

describe('ExtraFacilitiesComponent', () => {
  let component: ExtraFacilitiesComponent;
  let fixture: ComponentFixture<ExtraFacilitiesComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ExtraFacilitiesComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(ExtraFacilitiesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
