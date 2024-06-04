import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DashboardSubscriptionComponent } from './dashboard-subscription.component';

describe('DashboardSubscriptionComponent', () => {
  let component: DashboardSubscriptionComponent;
  let fixture: ComponentFixture<DashboardSubscriptionComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [DashboardSubscriptionComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(DashboardSubscriptionComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
