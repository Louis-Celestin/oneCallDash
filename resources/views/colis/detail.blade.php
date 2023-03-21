

<div class="modal fade" tabindex="-1" role="dialog" id="exampleModal{{ $gares[0]->nom_gare }}" aria-labelledby="exampleModal{{ $gares[0]->nom_gare }}Label" aria-hidden="true">
  <div class=" modal-dialog-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModal{{ $gares[0]->nom_gare }}Label">Détail de la gare d'expédition  {{$gares->where('id', $gares[0]->nom_gare)}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <table class="table" id="example{{ $item[0]->gare_id_envoi }}">
              <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>CODE</th>
                   
                    <th>COLIS</th>
                    <th>MONTANT</th>
                    <th>EXPEDITEUR</th>
                    <th>DESTINATAIRE</th>
                    <th>GARE DESTINATION</th>
                    <th>STATUT</th>
                </tr>
            </thead>
            <tbody>
              @foreach ($item as $items)

           
                
             
              <tr>
                  <td>{{$loop->index +1}}</td>
                  <td>{{date('d/m/Y H:i', strtotime($items->created_at))}}</td>
                  <td>{{$items->code}}</td>
                  
                  <td>{{$items->description}}</td>
                  <td>{{number_format($items->prix, 0, '', '.') . ""}}</td>
                  <td>{{$items->nom_expediteur}} <br> {{$items->num_expediteur}} </td>
                  <td>{{$items->nom_destinataire}} <br> {{$items->num_destinataire}} </td>
                  <td>{{$items->ville_destinataire}}</td>
                  <td>
                      @if ($items->statut == "Waiting")
                          
                          <button type="button" class="btn btn-warning">{{"En attente"}}</button>
                      @else
                     
                      <button type="button" class="btn btn-success">{{"Recu"}}</button>
                      @endif
                  </td>
              </tr>
              
              @endforeach
          </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
        </div>
        </div>
    <!-- /.modal-content -->
  </div>
</div>
