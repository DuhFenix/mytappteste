import { Component , OnInit } from '@angular/core';
import { FormGroup } from '@angular/forms';
import { LoginComponent } from './login/login.component';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})

export class AppComponent implements OnInit {
  public title = 'mytap';

  constructor(
  ){

  }

  ngOnInit() {}

}
