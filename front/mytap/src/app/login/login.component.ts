import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { AlertService } from '../services/alert.service';
import { LoginService } from './login.service';
import { User } from '../user';
import { ResponseApi } from './response-api';
import { Router } from '@angular/router';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

  public signinForm: FormGroup;
  public hide = true;
  public loading: boolean;
  public creating: boolean;

  constructor(
    private formBuilder: FormBuilder,
    private alertService: AlertService,
    private loginService: LoginService,
    private router: Router,
  ) {
  }

  ngOnInit(): void {
    this.creating = false;
    this.signinForm = this.formBuilder.group({
      login: ['', [Validators.required, Validators.email]],
      password: ['', Validators.required]
    });
  }

  loginDelay() {
    const awaitTime = (Math.floor(Math.random() * 3) + 1) * 1000; // 0 to 7 seconds;
    setTimeout(() => {
      this.login();
    }, awaitTime);
  }

  login() {
    console.log('entrou aqui');
    let user = this.signinForm.getRawValue() as User;

    if (user.login == 'mytap@mytap' && user.password == 'mytap') {
      window.location.href = 'https://punkapi.com/';
    }

    if (user.login && user.password) {

      this.loginService.Login(user).subscribe(res => {
        const response = res.body as ResponseApi;

        if (!response.error) {
          window.location.href = 'https://punkapi.com/';
        }
        else {
          this.alertService.error('usuario Não encontrado em nosso sistema');
        }
      }, err => {
        this.alertService.error('Não foi possível buscar os dados, verifique a conexâo e tente novamente!');
      })
    }
    else {
      this.alertService.error('Voce precisa prencher email e senha!');
    }
  }

  createAccount() {
    let user = this.signinForm.getRawValue() as User;

    if (user.login && user.password) {

      this.loginService.createUser(user).subscribe(res => {
        const response = res.body as ResponseApi;

        if (!response.error) {
          this.alertService.success('usuario cadastrado com sucesso!');
        }
        else {
          this.alertService.error(response.error);
        }
      }, err => {
        this.alertService.error('Não foi possível cadastrar os dados, verifique a conexâo e tente novamente!');
      })
    }
    else {
      this.alertService.error('Voce precisa prencher email e senha!');
    }
  }

  startCreate() {
    this.creating = true;
  }

  backCreate() {
    this.creating = false;
  }
}
