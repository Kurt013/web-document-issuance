<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<form>
  <label class="label">Name</label>
  <div>
    <input
      data-tr-rules="required|between:2,22|only:string"
      type="text"
      name="name"
    required
    />
    <div data-tr-feedback="name"></div>
  </div>
  <label>Email</label>
  <div>
    <input type="text" data-tr-rules="required|email|maxlength:32" name="email" />
    <div data-tr-feedback="email"></div>
  </div>
  <label>Message</label>
  <div>
    <textarea
      data-tr-rules="required|between:2,250|endWith:."
      name="message"
    ></textarea>
    <div data-tr-feedback="message"></div>
  </div>
  <p>
    <button type="submit" value="Submit" data-tr-submit>
      Submit
    </button>
  </p>
</form>

<script src="./assets/index.umd.js"></script>

<script>
    const tr = new Trivule();
    tr.init();
</script>
</body>
</html>