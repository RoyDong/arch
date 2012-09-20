<center>
    <h2>Sign in</h2>
    <form action="/signin" method="post"/>
        <?php echo $h->formMethod?>
        <div>
            <label>Username: </label><input type="text" name="username"/>
        </div>
        <div>
            <label>Password: </label><input type="password" name="password"/>
        </div>
        <button>Submit</button>
    </form>
</center>