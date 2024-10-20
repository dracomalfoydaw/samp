<form @submit.prevent="login" >
        <!-- Form Group (email address)-->
        <div class="form-group">
            <label class="small mb-1" for="inputEmailAddress">Email</label>
            <input class="form-control" id="inputEmailAddress" v-model.trim="email" type="email" placeholder="Enter email address" required>
            <span v-if="errors.email" style="color: red;">{{ errors.email }}</span>
        </div>
        <!-- Form Group (password)-->
        <div class="form-group">
            <label class="small mb-1" for="inputPassword">Password</label>
            <input class="form-control" id="inputPassword" v-model.trim="password" type="password" placeholder="Enter password" required>
            <span v-if="errors.password" style="color: red;">{{ errors.password }}</span>
        </div>
        <!-- Form Group (remember password checkbox)-->
        <div class="form-group">
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" id="rememberPasswordCheck" type="checkbox" v-model="rememberPassword">
                <label class="custom-control-label" for="rememberPasswordCheck">Remember password</label>
            </div>
        </div>
        <!-- Form Group (login box)-->
        <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
            <a class="small" href="auth-password-basic.html">Forgot Password?</a>
            <button type="submit" id="loginbutton" class="btn btn-primary">Login</button>
        </div>
    </form>