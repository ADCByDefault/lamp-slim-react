import './App.css';
import Alunno from './Alunno'
import FormDiInserimento from './FormDiInserimento'
import {useState, useEffect} from 'react'

function App() {

  useEffect(() => {
    popolaAlunni();
  },[])

  const [alunni, setAlunni] = useState([]);
  const [pronto, setpronto] = useState(false);
  const [mostraForm, setMostraForm] = useState(false);

  async function popolaAlunni(){
    const response = await fetch("http://localhost:8080/alunni", {method: "GET"});
    const array = await response.json();
    setAlunni(array);
    setpronto(true);
  }
  return (
    <div className="App">
      {
        pronto ?
          alunni && alunni.map(
            a => (
            <Alunno alunno={a} popolaAlunni={popolaAlunni} key={a.id} />
          ))
        :
         <div>Loading...</div>
      }

      <button onClick={() => setMostraForm(true)}>Inserisci nuovo alunno</button>
      { mostraForm &&
        <div>
          <div><FormDiInserimento popolaAlunni={popolaAlunni}/></div>
          <button onClick={() => setMostraForm(false)}>Annulla inserimento</button>
        </div>
      }
    </div>
  );
}

export default App;