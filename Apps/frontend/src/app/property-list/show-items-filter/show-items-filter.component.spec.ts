import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ShowItemsFilterComponent } from './show-items-filter.component';

describe('ShowItemsFilterComponent', () => {
  let component: ShowItemsFilterComponent;
  let fixture: ComponentFixture<ShowItemsFilterComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ShowItemsFilterComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(ShowItemsFilterComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
