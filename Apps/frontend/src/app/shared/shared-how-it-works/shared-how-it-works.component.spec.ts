import { ComponentFixture, TestBed } from '@angular/core/testing';

import { SharedHowItWorksComponent } from './shared-how-it-works.component';

describe('SharedHowItWorksComponent', () => {
  let component: SharedHowItWorksComponent;
  let fixture: ComponentFixture<SharedHowItWorksComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [SharedHowItWorksComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(SharedHowItWorksComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
