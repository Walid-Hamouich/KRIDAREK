import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PriceAreaComponent } from './price-area.component';

describe('PriceAreaComponent', () => {
  let component: PriceAreaComponent;
  let fixture: ComponentFixture<PriceAreaComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [PriceAreaComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(PriceAreaComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
