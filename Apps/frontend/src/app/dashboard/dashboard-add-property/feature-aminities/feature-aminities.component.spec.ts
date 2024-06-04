import { ComponentFixture, TestBed } from '@angular/core/testing';

import { FeatureAminitiesComponent } from './feature-aminities.component';

describe('FeatureAminitiesComponent', () => {
  let component: FeatureAminitiesComponent;
  let fixture: ComponentFixture<FeatureAminitiesComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [FeatureAminitiesComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(FeatureAminitiesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
