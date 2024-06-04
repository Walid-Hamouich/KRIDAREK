import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DashboardPropertyListComponent } from './dashboard-property-list.component';

describe('DashboardPropertyListComponent', () => {
  let component: DashboardPropertyListComponent;
  let fixture: ComponentFixture<DashboardPropertyListComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [DashboardPropertyListComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(DashboardPropertyListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
