<!-- region Modalvindue #for at tjekke kort data -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Skan kortet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <input
                        type="password"
                        class="form-control"
                        id="inputCardData"
                        aria-describedby="emailHelp"
                        placeholder="Kort data"
                        value=""
                    >
                    <div
                        id="cardDataHelp"
                        class="form-text"
                    >Ingen kortdata</div>
                </div>
            </div>

            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                    onclick="document.getElementById('inputCardData').value='';document.getElementById('cardDataHelp').innerHTML='Ingen kortdata';"
                >Luk</button>
                <button
                    type="button"
                    class="btn btn-primary"
                    onclick="(document.getElementById('inputCardData').value != '')?showCardData():'';"
                >Tjek kort</button>
            </div>
        </div>
    </div>
</div>

<script>
    var myModal = document.getElementById('exampleModal')
    var myInput = document.getElementById('inputCardData')

    myModal.addEventListener('shown.bs.modal', function () {
        myInput.focus();
    });

    function showCardData() {
        var str = document.getElementById('inputCardData').value;
        console.log(str);

        if (str.length == 0) {
            document.getElementById("cardDataHelp").innerHTML = "Input feltet er tomt - indgiv kortkode";
            return;
        } else {
            document.getElementById("cardDataHelp").innerHTML = "Tjekker kortet op mod databasen";

            const xmlhttp = new XMLHttpRequest();
            xmlhttp.onload = function() {
                msg = this.responseText;
                console.log(msg);
                document.getElementById("cardDataHelp").innerHTML = this.responseText;
            }

            xmlhttp.open("GET", "/admin/ajaxResponse.php?card=" + str);
            xmlhttp.send();
        }

        document.getElementById('inputCardData').value='';
    }
</script>
<!-- endregion: Modalvindue -->