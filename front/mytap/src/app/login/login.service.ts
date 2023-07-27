import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { User } from '../user';

@Injectable({
  providedIn: 'root'
})
export class LoginService {

  constructor(private http: HttpClient) {}

  createUser($user : User) {
    return this.http.post('http://localhost:8000' + '/user/createUser', {$user} ,  {observe: 'response'});
  }

  updateUser($user : User) {
    return this.http.post('http://localhost:8000' + '/user/updateUser', {$user} ,  {observe: 'response'});
  }

  deleteUser($user : User) {
    return this.http.post('http://localhost:8000' + '/user/deleteUser', {$user} ,  {observe: 'response'});
  }

  Login($user : User) {
    return this.http.post('http://localhost:8000' + '/user/login', {$user} ,  {observe: 'response'});
  }
}
