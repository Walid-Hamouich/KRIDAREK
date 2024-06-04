import { Component, OnInit } from '@angular/core';
import { PropertyLocationComponent } from './property-location/property-location.component';
import { PropertyInformationComponent } from './property-information/property-information.component';
import { PriceAreaComponent } from './price-area/price-area.component';
import { FeatureAminitiesComponent } from './feature-aminities/feature-aminities.component';
import { ExtraFacilitiesComponent } from './extra-facilities/extra-facilities.component';
import { ContactInformationComponent } from './contact-information/contact-information.component';
import { TitleComponent } from './title/title.component';
import Type from 'models/type.enum';
import { AbstractControl, FormControl, FormGroup, UntypedFormGroup, Validators } from '@angular/forms';
import { inArrayValidator } from 'utils/customFormValidators';
import AnnouncementManagerService from 'services/announcementmanager.service';
import CityManager from 'services/citymanager.service';
import City from 'models/city.interface';
import { LoaderComponent } from 'app/shared/loader/loader.component';
import CurrentUserService from 'services/currentuser.service';
import { Router } from '@angular/router';



@Component({
  selector: 'app-dashboard-add-property',
  standalone: true,
  imports: [TitleComponent, PropertyLocationComponent, PropertyInformationComponent, PriceAreaComponent,
    FeatureAminitiesComponent, ExtraFacilitiesComponent, ContactInformationComponent, ExtraFacilitiesComponent,
    LoaderComponent],
  templateUrl: './dashboard-add-property.component.html',
  styleUrl: './dashboard-add-property.component.css'
})
export class DashboardAddPropertyComponent implements OnInit {

  loading = false;
  isSubmitted = false;
  cities: City[] = [];
  successMessage: string | null = null;
  errorMessage: string | null = null;

  types = Object.values(Type).filter((item) => {
    return isNaN(Number(item));
  });

  addPropertyForm = new UntypedFormGroup({
    title: new FormControl('', [Validators.required]),
    description: new FormControl('', [Validators.required]),
    images: new FormControl('', [Validators.required]),
    city: new FormControl('', []),
    action: new FormControl('Vent', [inArrayValidator(['Vent', 'Location'])]),
    type: new FormControl(this.types[0], [Validators.required, inArrayValidator(this.types)]),
    price: new FormControl('', [Validators.required, Validators.pattern(/^\d+(?:\.\d+)?$/)]),
    area: new FormControl('', [Validators.required, Validators.pattern(/^\d+(?:\.\d+)?$/)]),
    contactPhone: new FormControl('', [Validators.required, Validators.pattern(/^0[678]\d{8}$/)]),
  });

  constructor(
    private announcementManager: AnnouncementManagerService,
    private cityManager: CityManager,
    private currentUserService: CurrentUserService,
    private router: Router
  ) {


  }

  ngOnInit(): void {
    this.loading = true;
    this.cityManager.loadCities((response) => {
      this.cities = response["hydra:member"];
      this.city.setValue(this.cities[0].id?.toString());
      this.city.setValidators([inArrayValidator(this.cities.map(city => city.id?.toString()))]);
      this.loading = false;
    })
  }

  addProperty() {
    this.isSubmitted = true;
    this.successMessage = null;
    this.errorMessage = null;
    if (this.addPropertyForm.valid) {
      this.loading = true;
      this.addPropertyForm.disable();
      this.announcementManager.addAnnouncement({
        title: this.title.value,
        description: this.description.value,
        price: this.price.value,
        contactPhone: this.contactPhone.value,
        images: this.images.value,
        area: this.area.value,
        publishedById: this.currentUserService.currentUser()?.id ?? 0,
        property: {
          action: this.action.value,
          type: this.type.value,
          cityId: this.city.value,
        }
      }, (response: any) => {
        this.loading = false;
        this.successMessage = "L'annonce a été ajouté avec succés";
        this.router.navigate(['/property-details', response.id]);
        this.addPropertyForm.enable();
      }, (response: any) => {
        this.loading = false;
        this.errorMessage = response.error.detail ?? 'Il y\'a une erreur!'
        this.addPropertyForm.enable();
      });
    }
  }

  get title(): AbstractControl {
    return this.addPropertyForm.get('title') ?? new FormControl();
  }

  get description(): AbstractControl {
    return this.addPropertyForm.get('description') ?? new FormControl();
  }

  get images(): AbstractControl {
    return this.addPropertyForm.get('images') ?? new FormControl();
  }

  get city(): AbstractControl {
    return this.addPropertyForm.get('city') ?? new FormControl();
  }

  get area(): AbstractControl {
    return this.addPropertyForm.get('area') ?? new FormControl();
  }

  get price(): AbstractControl {
    return this.addPropertyForm.get('price') ?? new FormControl();
  }

  get contactPhone(): AbstractControl {
    return this.addPropertyForm.get('contactPhone') ?? new FormControl();
  }

  get action(): AbstractControl {
    return this.addPropertyForm.get('action') ?? new FormControl();
  }

  get type(): AbstractControl {
    return this.addPropertyForm.get('type') ?? new FormControl();
  }

}
