var isEnc = false;
const cm = document.querySelector(".chat-messages");
if (cm) {
    window.addEventListener("keydown", (event) => {
        const isB = event.key.toLowerCase() === "b";
        const isCtrl = event.ctrlKey;

        if (isCtrl && isB) {

            if (isEnc) {
                document.querySelectorAll(".message").forEach(m => {
                    let p = m.children[1];
                    isEnc = false;
                    p.textContent = decryptText(p.textContent, secretkeyForEncryption);
                });
            } else {
                document.querySelectorAll(".message").forEach(m => {
                    let p = m.children[1];
                    isEnc = true;
                    p.textContent = encryptText(p.textContent, secretkeyForEncryption);
                });
            }
            event.preventDefault();
        }
    });
}