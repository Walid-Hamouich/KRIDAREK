import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DashboardAddPropertyComponent } from './dashboard-add-property.component';

describe('DashboardAddPropertyComponent', () => {
  let component: DashboardAddPropertyComponent;
  let fixture: ComponentFixture<DashboardAddPropertyComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [DashboardAddPropertyComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(DashboardAddPropertyComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
