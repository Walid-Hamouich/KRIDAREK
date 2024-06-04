import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PropertyLocationComponent } from './property-location.component';

describe('PropertyLocationComponent', () => {
  let component: PropertyLocationComponent;
  let fixture: ComponentFixture<PropertyLocationComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [PropertyLocationComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(PropertyLocationComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
