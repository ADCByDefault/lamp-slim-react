import { useState } from "react";

export default function FormDiInserimento({alunno, popolaAlunni}){
    const [nome, setNome] = useState(alunno !== null ? alunno.nome : "");
    const [cognome, setCognome] = useState(alunno !== null ? alunno.cognome : "");

    async function salvaAlunno(){
        { alunno == null ?
            await fetch(`http://localhost:8080/alunni`, 
                {  
                method: "POST",
                headers: { 'Content-Type': 'application/json'},
                body: JSON.stringify({nome: nome, cognome: cognome})
                }
            )
            :
            await fetch(`http://localhost:8080/alunni/` + alunno.id, 
                {  
                method: "PUT",
                headers: { 'Content-Type': 'application/json'},
                body: JSON.stringify({nome: nome, cognome: cognome})
                }
            )
        }
        
        popolaAlunni();
    }

    function gestisciCambioNome(e){
        setNome(e.target.value);
    }
    function gestisciCambioCognome(e){
        setCognome(e.target.value);
    }

    return(
        <>  {
                alunno !== null
                ?
                <h1>Form di modifica</h1>
                :
                <h1>Form di inserimento</h1>
            }
            <div>Nome: <input type="text" onChange={gestisciCambioNome} value={nome} /></div>
            <div>Cognome: <input type="text"  onChange={gestisciCambioCognome} value={cognome} /></div>
            <div><button onClick={salvaAlunno}>salva</button></div>
            {nome} <br />{cognome}

        </>

    )
}