import {useState} from 'react';

export default function Alunno({alunno, popolaAlunni, setAlunno, setMostraForm}){
    const [inCancellazione, setInCancellazione] = useState(false);
    const [inModifica, setInModifica] = useState(false);
    const [richiestaConferma, setRichiestaConferma] = useState(false);


    async function cancellaAlunno(){
        setRichiestaConferma(false);
        setInCancellazione(true)
        await fetch(`http://localhost:8080/alunni/${alunno.id}`, {method: "DELETE"});
        popolaAlunni();
    }
    function richiesta(){
        setRichiestaConferma(true);
    }



    function annulla(){
        setRichiestaConferma(false);
    }
    return(
        <div>
            {alunno.nome} {alunno.cognome}
            
            { richiestaConferma ?
                <span>Sei sicuro? 
                <button onClick={cancellaAlunno}>si</button>
                <button onClick={annulla}>no</button>
                </span>
            :
              <button onClick={richiesta}>Cancella</button>
            }
            { inCancellazione &&
                <span>in fase di cancellazione </span>
            }
            {
                <button onClick={() => {setAlunno(alunno); setMostraForm(true);}}>Modifica</button>
            }
            <hr />

        </div>

    )
}