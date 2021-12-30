<div class="container d-flex flex-column align-items-end">
    <a href="/"><button type="submit" class="btn btn-primary m-3">Start page</button></a>
</div>
<div class="container d-flex flex-column align-items-center mt-5">
    <h1>Authorization</h1>
    <p style="color: red;"><?php if (!empty($vars)) echo $vars[0];?></p>
    <form action="/account/login" class="form mb-3" method="post">
        <div class="form-group mr-5">
            <label for="username" class="mr-3">Name</label>
            <input type="text" class="form-control" name="uname" id="username">
        </div>
        <div class="form-group mr-5">
            <label for="password" class="mr-3">Password</label>
            <input type="password" class="form-control" name="password" id="password">
        </div>
        <button class="btn btn-primary mt-3" type="submit" name="signIn">Sign in</button>
    </form>
</div>