<?php 
//session_start();

?>

<div class="top-bar animate-dropdown">
	<div class="container">
		<div class="header-top-inner">
			<div class="cnt-account">
				<ul class="list-unstyled">

<?php if(strlen($_SESSION['login']))
    {   ?>
				<li><a href="#"><i class="icon fa fa-user"></i>Welcome -<?php echo htmlentities($_SESSION['username']);?></a></li>
				<?php } ?>

					<li><a href="my-account.php"><i class="icon fa fa-user"></i>My Account</a></li>
					<li><a href="my-wishlist.php"><i class="icon fa fa-heart"></i>Wishlist</a></li>
					<li><a href="my-cart.php"><i class="icon fa fa-shopping-cart"></i>My Cart</a></li>
					<?php if(strlen($_SESSION['login'])==0)
    {   ?>
<li><a href="login.php"><i class="icon fa fa-sign-in"></i>Login</a></li>
<?php }
else{ ?>
	
				<li><a href="logout.php"><i class="icon fa fa-sign-out"></i>Logout</a></li>
				<?php } ?>	
				</ul>
			</div><!-- /.cnt-account -->
						
					</li>

				
				</ul>
			</div>
			<!-- AI Chatbot Floating Button -->
 <!-- Chatbot Toggle Button (with Enhanced Features) -->
<style>
  #chatbot-toggle {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 9999;
    width: 75px;
    height: 75px;
    cursor: pointer;
    border: none;
    background: none;
  }

  #chatbot-toggle img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    transition: transform 0.2s ease;
  }

  #chatbot-toggle img:hover {
    transform: scale(1.1);
  }

  #chatbot-box {
    display: none;
    position: fixed;
    bottom: 100px;
    right: 20px;
    width: 320px;
    max-height: 420px;
    z-index: 9999;
    border-radius: 15px;
    overflow: hidden;
    background-color: #ffffff;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
  }

  #chatbot-messages {
    height: 260px;
    overflow-y: auto;
    padding: 15px;
    background-color: #f9f9fb;
    font-size: 14px;
  }

  #chatbot-box .card-header {
    background-color: #007bff;
    color: white;
    font-weight: bold;
    text-align: center;
    padding: 10px;
  }

  #chatbot-box .card-footer {
    background-color: #f1f1f1;
    padding: 10px;
  }

  .chat-msg {
    margin-bottom: 12px;
    line-height: 1.4;
  }

  .chat-msg.user {
    text-align: right;
    color: #007bff;
  }

  .chat-msg.ai {
    text-align: left;
    color: #333;
  }

  #typing {
    font-style: italic;
    color: gray;
  }
</style>

<!-- Robot Image Button -->
<button id="chatbot-toggle">
  <img src="https://img.freepik.com/premium-photo/illustrations-cute-friendly-chatbot-robots-interacting-with-various-digital-interfaces-speech_1143726-22724.jpg" alt="Chatbot">
</button>

<!-- Chatbot Box -->
<div id="chatbot-box" class="card">
  <div class="card-header">JARVIS</div>
  <div class="card-body" id="chatbot-messages">
    <div class="text-muted small">🤖 Hello! I am your site navigator.</div>
  </div>
  <div id="typing" class="text-muted small" style="display:none; text-align:left; padding-left:10px;">JARVIS is typing...</div>
  <div class="card-footer">
    <input list="commands" id="chatbot-input" class="form-control" placeholder="Type here...">
    
    <div style="padding-top:5px;">
      <button onclick="quickReply('home')">🏠 Home</button>
      <button onclick="quickReply('cart')">🛒 Cart</button>
      <button onclick="quickReply('login')">🔐 Login</button>
    </div>
  </div>
</div>

<script>
document.getElementById("chatbot-toggle").onclick = function() {
  var box = document.getElementById("chatbot-box");
  box.style.display = (box.style.display === "none") ? "block" : "none";
};

document.getElementById("chatbot-input").addEventListener("keydown", function(e) {
  if (e.key === "Enter") {
    const input = this.value.trim();
    const messages = document.getElementById("chatbot-messages");
    if (!input) return;
    messages.innerHTML += `<div class='chat-msg user'><strong>You:</strong> ${input}</div>`;
    document.getElementById("typing").style.display = "block";
    let reply = getAIResponse(input.toLowerCase());
    setTimeout(() => {
      document.getElementById("typing").style.display = "none";
      messages.innerHTML += `<div class='chat-msg ai'><strong>JARVIS:</strong> ${reply}</div>`;
      messages.scrollTop = messages.scrollHeight;
    }, 700);
    this.value = '';
  }
});

function quickReply(text) {
  document.getElementById("chatbot-input").value = text;
  document.getElementById("chatbot-input").dispatchEvent(new KeyboardEvent("keydown", {key: "Enter"}));
}

function getAIResponse(msg) {
  if (msg.includes("hello") || msg.includes("hi")) return "Hi! How can I help you today? 😊";
  if (msg.includes("whats your name")  || msg.includes("your name")|| msg.includes("name"))  return "I'm jarvis, your site navigator 🤖";
  if (msg.includes("time") || msg.includes("TIME") || msg.includes("Time")) return "It's " + new Date().toLocaleTimeString();
  if (msg.includes("date") || msg.includes("DATE") || msg.includes("Date")) return "Today is " + new Date().toLocaleDateString();
  if (msg.includes("home") || msg.includes("HOME")|| msg.includes("Home")) { window.location.href = "index.php"; return "Taking you to the home page 🏠"; }
  if (msg.includes("cart") || msg.includes("CART") || msg.includes("Cart")) { window.location.href = "my-cart.php"; return "Going to About page 📘"; }
  if (msg.includes("account") || msg.includes("ACCOUNT") || msg.includes("Account")) { window.location.href = "my-account.php"; return "Heading to Contact page 📞"; }
  if (msg.includes("wishlist")|| msg.includes("WISHLIST") || msg.includes("Wishlist")) { window.location.href = "my-wishlist.php"; return "Loading Services page 🛠️"; }
  if (msg.includes("login") || msg.includes("LOGIN") || msg.includes("Login")) { window.location.href = "login.php"; return "Loading Services page 🛠️"; }
  if (msg.includes("order") || msg.includes("ORDER") || msg.includes("Order")) { window.location.href = "order-details.php"; return "Loading Services page 🛠️"; }

  if (msg.includes("author") || msg.includes("owner") || msg.includes("OWNER")) { return "owner is himanshu"; }
  
  if (msg.includes("bye") || msg.includes("tata") || msg.includes("Bye")) { return "Goodbye! I hope you found what you were looking for. If you have any more questions or need assistance in the future, don't hesitate to reach out!"; }
  if (msg.includes("help")) return "You can ask me to go to Home ,cart ,account , wishlist , login , order or ask for the time,date,name!";

  return "Sorry, I didn’t understand that. Try 'help'.";
}
</script>
			<div class="clearfix"></div>
		</div><!-- /.header-top-inner -->
	</div><!-- /.container -->
</div><!-- /.header-top -->