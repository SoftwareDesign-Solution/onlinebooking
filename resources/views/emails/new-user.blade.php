Ein neuer User hat sich registriert und wartet auf Prüfung und Freischaltung.
E-Mail: {{ $user->email }}
Name: {{ $user->name }}
Telefonnummer: {{ $user->phone }}

Bitte logge dich ein um den User freizuschalten.
https://{{ request()->getHttpHost()  }}/cms
