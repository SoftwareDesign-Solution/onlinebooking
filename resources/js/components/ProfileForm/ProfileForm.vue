<style lang="scss" scoped src="./ProfileForm.scss"></style>
<script lang="ts" src="./ProfileForm.ts"></script>

<template>
    <div class="profile-form" v-if="user">
        <label>Name</label>
        <input type="text"
               v-bind:class="{ invalid: isInvalid('name') }"
               v-bind:disabled="!isFormEnabled"
               v-model:value="user.name">
        <div v-if="isInvalid('name')" class="validation-error">
            Der Name darf maximal 255 Zeichen enthalten.
        </div>

        <label>E-Mail-Adresse</label>
        <input type="email"
               v-bind:class="{ invalid: isInvalid('email') }"
               v-bind:disabled="!isFormEnabled"
               v-model:value="user.email">
        <div v-if="isInvalid('email')" class="validation-error">
            <template v-if="errors['email'].includes('validation.unique')">
                E-Mail bereits vergeben
            </template>
            <template v-if="!errors['email'].includes('validation.unique')">
                Ungültige E-Mail
            </template>
        </div>

        <label>Telefonnummer</label>
        <input type="tel"
               v-bind:class="{ invalid: isInvalid('phone') }"
               v-bind:disabled="!isFormEnabled"
               v-model:value="user.phone">
        <div v-if="isInvalid('phone')" class="validation-error">
            Ungültige Telefonnummer
        </div>

        <div class="buttons">
            <button v-on:click="toggleForm()" type="button">
                {{ isFormEnabled ? 'Daten speichern' : 'Daten ändern' }}
            </button>

            <a href="/password/change" class="button secondary">Passwort ändern</a>
        </div>

        <div v-on:click="$refs.confirmToast.show()" class="destructive">Account löschen</div>

        <toast ref="confirmToast" class="confirm-toast">
            <p>Bist du sicher?</p>
            <button v-on:click="deleteAccount()" type="button">Account löschen</button>
            <button class="cancel" v-on:click="$refs.confirmToast.hide()" type="button">Abbrechen</button>
        </toast>
    </div>
</template>

