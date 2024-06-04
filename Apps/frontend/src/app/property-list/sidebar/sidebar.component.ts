import { Component, EventEmitter, Output } from '@angular/core';
import { FormControl, FormGroup, FormsModule, ReactiveFormsModule, Validators } from '@angular/forms';
import { inArrayValidator } from 'utils/customFormValidators';

interface SearchInterface {
  city?: string
}


@Component({
  selector: 'app-sidebar',
  standalone: true,
  imports: [ReactiveFormsModule, FormsModule],
  templateUrl: './sidebar.component.html',
  styleUrl: './sidebar.component.css'
})
export class SidebarComponent {

  private cities = ["Oujda", "Berkane", "Guercif", "Nador",
    "Fes", "Mohammedia", "Casablanca"]

  searchForm = new FormGroup({
    city: new FormControl(this.cities[0], [inArrayValidator(this.cities)])
  });

  @Output()
  public search = new EventEmitter<SearchInterface>();


  searchEmitter() {
    if (this.searchForm.valid) {
      this.search.emit({ city: this.city.value });
    }
  }

  get getCities() { return this.cities; }

  get city(): FormControl {
    return this.searchForm.get('city') as FormControl;
  }

}
