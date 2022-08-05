<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBarangRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UpdateBarangRequest;
use App\InOut;
use Carbon\Carbon;

use App\PembatalanUnit;
use App\PenerimaanBarang;
use App\Pengajuan;
use App\Penggajian;
use App\Purchase;
use App\Reinburst;
use App\Spr;
use App\TukarFaktur;

class AjaxController extends Controller
{
  
    public function ajax_gaji( Request $request)
    {
        if(request()->ajax()){
            if(!empty($request->from_date))
            {
                $gaji = Penggajian::where('admin',auth()->user()->name)
                ->whereBetween('tanggal', array($request->from_date, $request->to_date))->orderBy('id', 'desc')->get();

            }else{
                $gaji = Penggajian::where('admin',auth()->user()->name)->orderBy('id', 'desc')->get();
            }
            return datatables()
                ->of($gaji)
                ->editColumn('pegawai', function ($gajian) {
                    return $gajian->pegawai->name;
                })
                ->editColumn('tanggal', function ($gajian) {
                    return Carbon::parse($gajian->tanggal)->format('d/m/Y');
                })
                ->editColumn('bulan_tahun', function ($gajian) {
                    return Carbon::parse($gajian->bulan_tahun)->format('F/Y');
                })
                ->editColumn('gaji_pokok', function ($gajian) {
                    return $gajian->gaji_pokok;
                })
                ->editColumn('penerimaan', function ($gajian) {
                    return $gajian->penerimaan->sum('nominal') - $gajian->gaji_pokok;
                })
                ->editColumn('potongan', function ($gajian) {
                    return $gajian->potongan->sum('nominal');
                })
                ->editColumn('total', function ($gajian) {
                    return $gajian->gaji_pokok + (($gajian->penerimaan->sum('nominal') - $gajian->gaji_pokok) - $gajian->potongan->sum('nominal'));
                })
                ->editColumn('jabatan', function ($gajian) {
                    return $gajian->jabatan;
                })
                ->editColumn('divisi', function ($gajian) {
                    return $gajian->divisi;
                })
                ->editColumn('admin', function ($gajian) {
                    return $gajian->admin;
                })
                ->editColumn('action', function ($gajian) {
                    
                    Penggajian::where('id', $gajian->id)->get();
            
                    
                    return '<a href="' . route('hrd.gaji.print', $gajian->id) . '"class="btn btn-sm btn-secondary"><i class="fa-solid fa-print"></i></a>
                     <a href="' . route('hrd.gaji.show', $gajian->id) . '"class="btn btn-sm btn-success"><i class="fa-solid fa-eye"></i></a>
                    <a href="' . route('hrd.gaji.edit', $gajian->id) . '"class="btn btn-sm btn-warning"><i class="fa-solid fa-pen-to-square"></i></a> 
                    <a href="' . route('hrd.gaji.hapus', $gajian->id) . '"   class="delete-form btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>';
                })
                ->addIndexColumn()
                ->rawColumns(['pegawai','action'])
                ->make(true);
        }

 
    }

    //rekap reinburst
    public function ajax_rekap_reinburst(Request $request)
    {
        if(request()->ajax())
        {
            if(!empty($request->from_date))
            {
            $reinbursts = Reinburst::
            leftJoin('rincian_reinbursts','reinbursts.nomor_reinburst','=','rincian_reinbursts.nomor_reinburst')
            ->select('reinbursts.id_user','reinbursts.nomor_reinburst','reinbursts.status_hrd','reinbursts.status_pembayaran','reinbursts.tanggal_reinburst',
            'rincian_reinbursts.total','reinbursts.id')
            ->whereBetween('reinbursts.tanggal_reinburst', array($request->from_date, $request->to_date))
            ->groupBy('reinbursts.nomor_reinburst')
            ->orderBy('reinbursts.id', 'desc')->where('reinbursts.status_hrd','completed')
            ->get();
            // dd($reinbursts);
            }
            else
            {
                $reinbursts = Reinburst::
                leftJoin('rincian_reinbursts','reinbursts.nomor_reinburst','=','rincian_reinbursts.nomor_reinburst')
                ->select('reinbursts.id_user','reinbursts.nomor_reinburst','reinbursts.status_hrd','reinbursts.status_pembayaran','reinbursts.tanggal_reinburst',
                'rincian_reinbursts.total','reinbursts.id')
                ->groupBy('reinbursts.nomor_reinburst')
                ->orderBy('reinbursts.id', 'desc')->where('reinbursts.status_hrd','completed')
                ->get();

            }

            return datatables()
                ->of($reinbursts)
                ->editColumn('no_reinburst', function ($reinburst) {
                    return '<a href="' . route("admin.reinburst.show", $reinburst->id) . '">' . $reinburst->nomor_reinburst . '</a>';
                })
                ->editColumn('tanggal', function ($reinburst) {
                    return Carbon::parse($reinburst->tanggal_reinburst)->format('d/m/Y');
                })
                ->editColumn('total', function ($reinburst) {
                    return \App\Reinburst::where('nomor_reinburst', $reinburst->nomor_reinburst)->count();
                })
                ->editColumn('pembelian', function ($reinburst) {
                    return $reinburst->total;
                })
                ->editColumn('status_hrd', function ($reinburst) {
                    if($reinburst->status_hrd == 'pending'){
                   return '<a class="custom-badge status-red">pending</a>';
                   }
                    if($reinburst->status_hrd == 'completed'){
                        return '<a class="custom-badge status-green">completed</a>';
                    }
                    if($reinburst->status_hrd == 'review'){
                        return '<a class="custom-badge status-orange">review</a>';
                    }
                })
                ->editColumn('status_pembayaran', function ($reinburst) {
                    if($reinburst->status_pembayaran == 'pending'){
                        return '<a class="custom-badge status-red">pending</a>';
                        }
                         if($reinburst->status_pembayaran == 'completed'){
                             return '<a class="custom-badge status-green">completed</a>';
                         }
                         if($reinburst->status_pembayaran == 'review'){
                             return '<a class="custom-badge status-orange">review</a>';
                         }
                })
                ->addIndexColumn()
                ->rawColumns(['no_reinburst','pembelian','status_hrd','status_pembayaran'])
                ->make(true);
        }

    }

    // acc-reinburst
    public function ajax_acc_reinburst(Request $request){
        if(request()->ajax())
        {
            if(!empty($request->from_date))
            {
                $reinbursts = Reinburst::
                leftJoin('rincian_reinbursts','reinbursts.nomor_reinburst','=','rincian_reinbursts.nomor_reinburst')
                ->select('reinbursts.id_user','reinbursts.nomor_reinburst','reinbursts.status_hrd','reinbursts.status_pembayaran','reinbursts.tanggal_reinburst',
                'rincian_reinbursts.total','reinbursts.id')->where('reinbursts.status_hrd','!=','completed')
                ->whereBetween('reinbursts.tanggal_reinburst', array($request->from_date, $request->to_date))
                ->groupBy('reinbursts.nomor_reinburst')
                ->orderBy('reinbursts.id', 'desc')
                ->get();
            }
            else
        {
            
            $reinbursts = Reinburst::
            leftJoin('rincian_reinbursts','reinbursts.nomor_reinburst','=','rincian_reinbursts.nomor_reinburst')
            ->select('reinbursts.id_user','reinbursts.nomor_reinburst','reinbursts.status_hrd','reinbursts.status_pembayaran','reinbursts.tanggal_reinburst',
            'rincian_reinbursts.total','reinbursts.id')->where('reinbursts.status_hrd','!=','completed')
            ->groupBy('reinbursts.nomor_reinburst')
            ->orderBy('reinbursts.id', 'desc')
            ->get();
            // dd($reinbursts);
        }
        return datatables()
        ->of($reinbursts)
        ->editColumn('no_reinburst', function ($reinburst) {
            return '<a href="' . route("admin.reinburst.show", $reinburst->id) . '">' . $reinburst->nomor_reinburst . '</a>';
        })
        ->editColumn('tanggal', function ($reinburst) {
            return Carbon::parse($reinburst->tanggal_reinburst)->format('d/m/Y');
        })
        ->editColumn('total', function ($reinburst) {
            return \App\Reinburst::where('nomor_reinburst', $reinburst->nomor_reinburst)->count();
        })
        ->editColumn('pembelian', function ($reinburst) {
            return $reinburst->total;
        })
        ->editColumn('status_hrd', function ($reinburst) {
            if($reinburst->status_hrd == 'pending'){
           return '<a class="custom-badge status-red">pending</a>';
           }
            if($reinburst->status_hrd == 'completed'){
                return '<a class="custom-badge status-green">completed</a>';
            }
            if($reinburst->status_hrd == 'review'){
                return '<a class="custom-badge status-orange">review</a>';
            }
        })
        ->editColumn('status_pembayaran', function ($reinburst) {
            if($reinburst->status_pembayaran == 'pending'){
                return '<a class="custom-badge status-red">pending</a>';
                }
                 if($reinburst->status_pembayaran == 'completed'){
                     return '<a class="custom-badge status-green">completed</a>';
                 }
                 if($reinburst->status_pembayaran == 'review'){
                     return '<a class="custom-badge status-orange">review</a>';
                 }
        })
        ->editColumn('action', function ($data) {
            
            Reinburst::where('id', $data->id)->get();
            $button = '<a href="' . route('hrd.penerimaan.statuscompleted', $data->id) . '"  class="custom-badge status-green"><i class="fa-solid fa-check-to-slot"></i></a>';
            return $button;
            
            // return '<a href="' . route('hrd.penerimaan.statuscompleted', $data->id) . '"  class="custom-badge status-green"><i class="fa-solid fa-check-to-slot"></i></a>
            // <a href="' . route('hrd.penerimaan.update', $data->id) . '"  class="custom-badge status-orange"><i class="fa-solid fa-eye"></i></a>';
         

        })
        ->addIndexColumn()
        ->rawColumns(['no_reinburst','status_hrd','status_pembayaran','action'])
        ->make(true);
        }

       
    }
    public function ajax_reinburst(Request $request){

        if(request()->ajax()){
            if(!empty($request->from)){
                $reinbursts = Reinburst::
                leftJoin('rincian_reinbursts','reinbursts.nomor_reinburst','=','rincian_reinbursts.nomor_reinburst')
                ->select('reinbursts.id_user','reinbursts.nomor_reinburst','reinbursts.status_hrd','reinbursts.status_pembayaran','reinbursts.tanggal_reinburst',
                'rincian_reinbursts.total','reinbursts.id')->where('reinbursts.id_user',auth()->user()->id)
                ->whereBetween('reinbursts.tanggal_reinburst', array($request->from, $request->to))
                ->groupBy('reinbursts.nomor_reinburst')
                ->orderBy('reinbursts.id', 'desc')
                ->get();
                // dd($reinbursts);

            }else{


                $reinbursts = Reinburst::
                leftJoin('rincian_reinbursts','reinbursts.nomor_reinburst','=','rincian_reinbursts.nomor_reinburst')
                ->select('reinbursts.id_user','reinbursts.nomor_reinburst','reinbursts.status_hrd','reinbursts.status_pembayaran','reinbursts.tanggal_reinburst',
                'rincian_reinbursts.total','reinbursts.id')->where('reinbursts.id_user',auth()->user()->id)
                ->groupBy('reinbursts.nomor_reinburst')
                ->orderBy('reinbursts.id', 'desc')
                ->get();
                // dd($reinbursts);

            }

        return datatables()
            ->of($reinbursts)
            ->editColumn('no_reinburst', function ($reinburst) {
                return '<a href="' . route("admin.reinburst.show", $reinburst->id) . '">' . $reinburst->nomor_reinburst . '</a>';
            })
            ->editColumn('tanggal', function ($reinburst) {
                return Carbon::parse($reinburst->tanggal_reinburst)->format('d/m/Y');
            })
            ->editColumn('total', function ($reinburst) {
                return \App\Reinburst::where('nomor_reinburst', $reinburst->nomor_reinburst)->count();
            })
            ->editColumn('pembelian', function ($reinburst) {
                return $reinburst->total;
            })
            ->editColumn('status_hrd', function ($reinburst) {
                if($reinburst->status_hrd == 'pending'){
               return '<a class="custom-badge status-red">pending</a>';
               }
                if($reinburst->status_hrd == 'completed'){
                    return '<a class="custom-badge status-green">completed</a>';
                }
                if($reinburst->status_hrd == 'review'){
                    return '<a class="custom-badge status-orange">review</a>';
                }
            })
            ->editColumn('status_pembayaran', function ($reinburst) {
                if($reinburst->status_pembayaran == 'pending'){
                    return '<a class="custom-badge status-red">pending</a>';
                    }
                     if($reinburst->status_pembayaran == 'completed'){
                         return '<a class="custom-badge status-green">completed</a>';
                     }
                     if($reinburst->status_pembayaran == 'review'){
                         return '<a class="custom-badge status-orange">review</a>';
                     }
            })
            ->editColumn('action', function ($data) {
                
                Reinburst::where('id', $data->id)->get();
                return '<a href="' . route('purchasing.reinburst.pdf', $data->id) . '"class="btn btn-sm btn-secondary"><i class="fa-solid fa-print"></i></a>
                <a href="' .  route('purchasing.reinburst.destroy', $data->id). '" class="delete-form btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>';

            })
            ->addIndexColumn()
            ->rawColumns(['no_reinburst','status_hrd','status_pembayaran','action'])
            ->make(true);
        }
    }
    public function ajax_pengajuan(Request $request){

        if(request()->ajax()){

            if(!empty($request->from_date))
            {
                
                $pengajuans = Pengajuan::
                leftJoin('rincian_pengajuans','pengajuans.nomor_pengajuan','=','rincian_pengajuans.nomor_pengajuan')
                ->leftJoin('roles','pengajuans.id_roles','=','roles.id')
                ->select('roles.name','pengajuans.id','pengajuans.status_approval','pengajuans.id_user','pengajuans.nomor_pengajuan','pengajuans.tanggal_pengajuan',
                'rincian_pengajuans.grandtotal','pengajuans.id_perusahaan','pengajuans.id_roles')->where('pengajuans.id_user',auth()->user()->id)
                ->whereBetween('pengajuans.tanggal_pengajuan', array($request->from_date, $request->to_date))
                ->groupBy('pengajuans.nomor_pengajuan')
                ->orderBy('pengajuans.id', 'desc')
                ->get();
                // dd($pengajuans);

            }else{
                $pengajuans = Pengajuan::
                leftJoin('rincian_pengajuans','pengajuans.nomor_pengajuan','=','rincian_pengajuans.nomor_pengajuan')
                ->leftJoin('roles','pengajuans.id_roles','=','roles.id')
                ->select('roles.name','pengajuans.id','pengajuans.status_approval','pengajuans.id_user','pengajuans.nomor_pengajuan','pengajuans.tanggal_pengajuan',
                'rincian_pengajuans.grandtotal','pengajuans.id_perusahaan','pengajuans.id_roles')->where('pengajuans.id_user',auth()->user()->id)
                ->groupBy('pengajuans.nomor_pengajuan')
                ->orderBy('pengajuans.id', 'desc')
                ->get();
                // dd($pengajuans);
            }
            return datatables()
                ->of($pengajuans)
                ->editColumn('no_pengajuan', function ($pengajuan) {
                    return '<a href="' . route("logistik.pengajuan.show", $pengajuan->id) . '">' . $pengajuan->nomor_pengajuan . '</a>';
                })
                ->editColumn('perusahaan', function ($pengajuan) {
                    return $pengajuan->perusahaan->nama_perusahaan;
                })
                ->editColumn('tanggal', function ($pengajuan) {
                    return Carbon::parse($pengajuan->tanggal_pengajuan)->format('d/m/Y');
                })
                ->editColumn('divisi', function ($pengajuan) {
                    return $pengajuan->roles->name;
                })
                ->editColumn('nama', function ($pengajuan) {
                    return $pengajuan->admin->name;
                })
                ->editColumn('total', function ($pengajuan) {
                    return \App\Pengajuan::where('nomor_pengajuan', $pengajuan->nomor_pengajuan)->count();
                })
                ->editColumn('pembelian', function ($pengajuan) {
                    return $pengajuan->grandtotal;
                })
                ->editColumn('status', function ($pengajuan) {
                    if($pengajuan->status_approval == 'pending'){
                   return '<a class="custom-badge status-red">pending</a>';
                   }
                    if($pengajuan->status_approval == 'completed'){
                        return '<a class="custom-badge status-green">completed</a>';
                    }
                   
                })
                ->editColumn('action', function ($data) {
                    
                    Pengajuan::where('id', $data->id)->get();
                    $button = '<a href="' . route('hrd.pengajuan.pdf', $data->id) . '"class="btn btn-sm btn-secondary"><i class="fa-solid fa-print"></i></a>';
                    $button .= '<a href="' . route('hrd.pengajuan.destroy', $data->id) . '"   class=" delete-form btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>';
                    return $button;
                })
                ->addIndexColumn()
                ->rawColumns(['no_pengajuan','status','action'])
                ->make(true);
        }

    }


    public function ajax_purchase(Request $request){
        if(request()->ajax()){
            if(!empty($request->from)){
                
                $purchases = Purchase::groupBy('invoice')
                ->orderBy('id', 'desc')
                ->whereBetween('created_at',array($request->from, $request->to))
                ->get();
                // dd($purchases);
            }else{

                $purchases = Purchase::groupBy('invoice')
                ->orderBy('id', 'desc')
                ->get();
                // dd($purchases);
            }

        return datatables()
            ->of($purchases)
            ->editColumn('no_invoice', function ($purchase) {
                return '<a href="' . route("logistik.purchase.show", $purchase->id) . '">' . $purchase->invoice . '</a>';
            })
            ->editColumn('admin', function ($purchase) {
                return $purchase->admin->name;
            })
            ->editColumn('tanggal', function ($purchase) {
                return Carbon::parse($purchase->created_at)->format('d/m/Y');
            })
            ->editColumn('total', function ($purchase) {
                return \App\Purchase::where('invoice', $purchase->invoice)->count();
            })
            ->editColumn('pembelian', function ($purchase) {
                return $purchase->grand_total;
            })
            ->editColumn('status', function ($purchase) {
                if($purchase->status_barang == 'pending'){
               return '<a class="custom-badge status-red">pending</a>';
               }
                if($purchase->status_barang == 'completed'){
                    return '<a class="custom-badge status-green">completed</a>';
                }
               
            })
            ->editColumn('action', function ($data) {
                
                Pengajuan::where('id', $data->id)->get();
            
               
             
                $button = '<a href="' . route('logistik.purchase.pdf', $data->id) . '"class="btn btn-sm btn-secondary"><i class="fa-solid fa-print"></i></a>';
                $button .= '<a href="' . route('logistik.purchase.destroy', $data->id) . '"   class=" delete-form btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>';
                return $button;
            })
            ->addIndexColumn()
            ->rawColumns(['no_invoice','status','action'])
            ->make(true);
        }
    }

    public function ajax_product(Request $request){
        if(request()->ajax()){
            if(!empty($request->from)){

                $barangs = InOut::where('user_id',auth()->user()->id)->orderBy('id','desc')
                ->whereBetween('created_at', array($request->from, $request->to))
                ->get();
            }else{
                
                $barangs = InOut::where('user_id',auth()->user()->id)->orderBy('id','desc')->get();
                // dd($barangs);


            }
        return datatables()
            ->of($barangs)
            ->editColumn('item', function ($product) {
               return $product->barang->nama_barang;
            })
            ->editColumn('supplier', function ($product) {
                return $product->supplier->nama;
            })
            ->editColumn('project', function ($product) {
                return $product->cabang->nama_project;
            })
            ->editColumn('in', function ($product) {
                return $product->in ?? '-';
            })
            ->editColumn('out', function ($product) {
                return $product->out ?? '-';
            })
            ->editColumn('last', function ($product) {
                return $product->in - $product->out;
            })
            ->editColumn('waktu', function ($product) {
                return Carbon::parse($product->created_at)->format('d/m/Y');
            })
            ->editColumn('admin', function ($product) {
                return $product->admin->name;
            })
        
            ->addIndexColumn()
            ->rawColumns(['no_invoice','status','action'])
            ->make(true);
    }
    }

    public function ajax_penerimaan(Request $request)
    {
     if(request()->ajax()){

         if (!empty($request->from)) {
              $penerimaans = PenerimaanBarang::groupBy('no_penerimaan_barang')
              ->whereBetween('tanggal_penerimaan', array($request->from, $request->to))->where('id_user',auth()->user()->id)->get();
          } else {
              $penerimaans = PenerimaanBarang::groupBy('no_penerimaan_barang')
              ->where('id_user',auth()->user()->id)
              ->orderBy('id', 'desc')->get();
              
          }
          // dd($penerimaans);
          return datatables()
              ->of($penerimaans)
              ->editColumn('no_penerimaan', function ($penerimaan) {
                  return '<a href="' . route("purchasing.penerimaan-barang.show", $penerimaan->id) . '">' . $penerimaan->no_penerimaan_barang . '</a>';
              })
              ->editColumn('diajukan', function ($penerimaan) {
                  return $penerimaan->admin->name;
              })
              ->editColumn('tanggal', function ($penerimaan) {
                  return Carbon::parse($penerimaan->tanggal_penerimaan)->format('d/m/Y');
              })
              
              ->editColumn('total', function ($penerimaan) {
                  return \App\PenerimaanBarang::where('no_penerimaan_barang', $penerimaan->no_penerimaan_barang)->count();
              })
              ->editColumn('pembelian', function ($penerimaan) {
                  return $penerimaan->grandtotal;
              })
          
              ->editColumn('status', function ($penerimaan) {
                  if($penerimaan->status_tukar_faktur == 'pending'){
                 return '<a class="custom-badge status-red">pending</a>';
                 }
                  if($penerimaan->status_tukar_faktur == 'completed'){
                      return '<a class="custom-badge status-green">completed</a>';
                  }
                 
              })
              ->editColumn('action', function ($penerimaan) {
                  
                  PenerimaanBarang::where('id', $penerimaan->id)->get();
              
                
                //   $button = '<a href="' . route('purchasing.tukarfaktur.pdf', $penerimaan->id) . '"class="btn btn-sm btn-secondary"><i class="fa-solid fa-print"></i></a>';
                  $button = '<a href="' . route('purchasing.penerimaan-barang.hapus', $penerimaan->id) . '"   class="delete-form delete-form btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>';
                  return $button;
               
  
              })
              ->addIndexColumn()
              ->rawColumns(['no_penerimaan', 'status','action'])
              ->make(true);
              // ->addColumn('action', function ($row) {
              //     $html = '<a href="" class="btn btn-xs btn-secondary">Edit</a> ';
              //     $html .= '<button data-rowid="'.$row->id.'" class="btn btn-xs btn-danger">Del</button>';
              //     return $html;
              // })
              
              // ->toJson()
        }
    }

    public function ajax_faktur(Request $request)
    {
     if(request()->ajax())
     {
        if (!empty($request->from)) {
            $tukar = DB::table('tukar_fakturs')
            ->whereBetween('tanggal_tukar_faktur', array($request->from, $request->to))
            ->where('id_user',auth()->user()->id)
            ->groupBy('tukar_fakturs.no_faktur')
            ->orderBy('tukar_fakturs.id','desc')
            ->get();    

        
        } else {

            $tukar = DB::table('tukar_fakturs')
            ->where('id_user',auth()->user()->id)
            ->groupBy('tukar_fakturs.no_faktur')
            ->orderBy('tukar_fakturs.id','desc')
            ->get();   
            // dd($tukar);
                
        }
        // dd($penerimaans);
        return datatables()
            ->of($tukar)
            ->editColumn('no_tukar', function ($tukars) {
                return '<a href="' . route("purchasing.tukarfaktur.show", $tukars->id) . '">' . $tukars->no_faktur . '</a>';
            })
            ->editColumn('status_po', function ($tukars) {
                if($tukars->po_spk == '1'){
               return '<a class="custom-badge status-orange">PO</a>';
               }
                if($tukars->po_spk == '2'){
                    return '<a class="custom-badge status-green">SPK</a>';
                }
               
            })
            ->editColumn('tanggal', function ($tukars) {
                return Carbon::parse($tukars->tanggal_tukar_faktur)->format('d/m/Y');
            })
            ->editColumn('invoice', function ($tukars) {
                return $tukars->no_invoice;
            })
            
            ->editColumn('total', function ($tukars) {
                return  \App\TukarFaktur::where('no_faktur', $tukars->no_faktur)->count();
            })
            ->editColumn('pembelian', function ($tukars) {
                return $tukars->nilai_invoice;
            })
            ->editColumn('status', function ($tukars) {
                if($tukars->status_pembayaran == 'pending'){
               return '<a class="custom-badge status-red">pending</a>';
               }
                if($tukars->status_pembayaran == 'completed'){
                    return '<a class="custom-badge status-green">completed</a>';
                }
               
            })
            ->editColumn('action', function ($tukars) {
                
                TukarFaktur::where('id', $tukars->id)->get();
            
                $button = '<a href="' . route('purchasing.tukarfaktur.pdf', $tukars->id) . '"class="btn btn-sm btn-secondary"><i class="fa-solid fa-print"></i></a>';
                $button .= '<a href="' . route('purchasing.tukarfaktur.destroy', $tukars->id) . '"   class="delete-form btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>';
                return $button;
             

            })
            ->addIndexColumn()
            ->rawColumns(['no_tukar', 'status','status_po','action'])
            ->make(true);
            // ->addColumn('action', function ($row) {
            //     $html = '<a href="" class="btn btn-xs btn-secondary">Edit</a> ';
            //     $html .= '<button data-rowid="'.$row->id.'" class="btn btn-xs btn-danger">Del</button>';
            //     return $html;
            // })
            
            // ->toJson()
     }
    }
    public function ajax_listpurchase(Request $request)
    {
        if(request()->ajax()){
     
        if (!empty($request->from)) {
            $purchases = DB::table('purchases')
            ->leftJoin('tukar_fakturs','purchases.invoice','=','tukar_fakturs..no_po_vendor')
            ->leftJoin('users','purchases.user_id','=','users.id')
            ->select('purchases.id','users.name','purchases.invoice','purchases.created_at','purchases.grand_total','tukar_fakturs.nilai_invoice','tukar_fakturs.no_po_vendor')
            ->groupBy('purchases.invoice')
            ->whereBetween('purchases.created_at',array($request->from, $request->to ))
            ->orderBy('purchases.id','desc')->get();
        
        } else {
            $purchases = DB::table('purchases')
            ->leftJoin('tukar_fakturs','purchases.invoice','=','tukar_fakturs..no_po_vendor')
            ->leftJoin('users','purchases.user_id','=','users.id')
            ->select('tukar_fakturs.status_pembayaran','purchases.id','users.name','purchases.invoice',
            'purchases.created_at','purchases.grand_total','tukar_fakturs.nilai_invoice','tukar_fakturs.total','tukar_fakturs.no_po_vendor')
            ->groupBy('purchases.invoice')
            ->orderBy('purchases.id','desc')->get();
            // dd($tukar);
                
        }
        // dd($penerimaans);
        return datatables()
            ->of($purchases)
            ->editColumn('no_purchase', function ($purchase) {
                return '<a href="' . route("purchasing.listpurchase.show", $purchase->id) . '">' . $purchase->invoice . '</a>';
            })
           
            ->editColumn('name', function ($purchase) {
                return $purchase->name;
            })
            ->editColumn('tanggal', function ($purchase) {
                return Carbon::parse($purchase->created_at)->format('d/m/Y');
            })
            
            ->editColumn('total', function ($purchase) {
                return  \App\Purchase::where('invoice', $purchase->invoice)->count();
            })
            ->editColumn('pembelian', function ($purchase) {
                return $purchase->grand_total;
            })
            ->editColumn('pembelian_purchase', function ($purchase) {
                return \App\TukarFaktur::where('no_po_vendor', $purchase->no_po_vendor)->where('status_pembayaran','completed')->sum('total');
            })
            ->editColumn('status', function ($purchase) {
                if($purchase->grand_total != \App\TukarFaktur::where('no_po_vendor', $purchase->no_po_vendor)->where('status_pembayaran','completed')->sum('total')){
               return '<a class="custom-badge status-red">Unpaid</a>';
               }
                if($purchase->grand_total == \App\TukarFaktur::where('no_po_vendor', $purchase->no_po_vendor)->where('status_pembayaran','completed')->sum('total')){
                    return '<a class="custom-badge status-green">Paid</a>';
                }
               
            })
      
            ->addIndexColumn()
            ->rawColumns(['no_purchase', 'status','pembelian_purchase'])
            ->make(true);
            // ->addColumn('action', function ($row) {
            //     $html = '<a href="" class="btn btn-xs btn-secondary">Edit</a> ';
            //     $html .= '<button data-rowid="'.$row->id.'" class="btn btn-xs btn-danger">Del</button>';
            //     return $html;
            // })
            
            // ->toJson()
        }
    }

    public function ajax_pembatalan(Request $request)
    {
        if(request()->ajax()){
            if(!empty($request->from)){

        $pembatalans = DB:: table('pembatalan_unit')
        ->leftjoin('spr','pembatalan_unit.spr_id','=','spr.id_transaksi')
        ->leftjoin('unit_rumah','spr.id_unit','=','unit_rumah.id_unit_rumah')
        ->leftjoin('users','spr.id_sales','=','users.id')
        ->whereBetween('pembatalan_unit.tanggal',array($request->from, $request->to))
        ->select('pembatalan_unit.tanggal','spr.no_transaksi','users.name','spr.status_approval',
        'spr.id_sales','pembatalan_unit.no_pembatalan','pembatalan_unit.id','pembatalan_unit.diajukan','unit_rumah.type','spr.no_transaksi','spr.harga_net','spr.status_dp','spr.status_booking','spr.nama','pembatalan_unit.status')
        ->get();
        // dd($pembatalans);
    }else{
        $pembatalans = DB:: table('pembatalan_unit')
        ->leftjoin('spr','pembatalan_unit.spr_id','=','spr.id_transaksi')
        ->leftjoin('unit_rumah','spr.id_unit','=','unit_rumah.id_unit_rumah')
        ->leftjoin('users','spr.id_sales','=','users.id')
        ->select('pembatalan_unit.tanggal','spr.no_transaksi','users.name','spr.status_approval','spr.id_sales','pembatalan_unit.no_pembatalan','pembatalan_unit.id','pembatalan_unit.diajukan','unit_rumah.type','spr.no_transaksi','spr.harga_net','spr.status_dp','spr.status_booking','spr.nama','pembatalan_unit.status')
        ->get();
        // dd($pembatalans);
        
            }
        return datatables()
            ->of($pembatalans)
            ->editColumn('no_pembatalan', function ($pembatalan) {
                return $pembatalan->no_pembatalan;
            })
            ->editColumn('tanggal', function ($pembatalan) {
                return Carbon::parse($pembatalan->tanggal)->format('d/m/Y');
            })
            ->editColumn('type', function ($pembatalan) {
                return $pembatalan->type;
            })
            ->editColumn('spr', function ($pembatalan) {
                return $pembatalan->no_transaksi;
            })
            ->editColumn('total_beli', function ($pembatalan) {
                return $pembatalan->harga_net;
            })
            ->editColumn('konsumen', function ($pembatalan) {
                return $pembatalan->nama;
            })
            ->editColumn('sales', function ($pembatalan) {
                return $pembatalan->name;
            })
            ->editColumn('booking_fee', function ($pembatalan) {
                return $pembatalan->status_booking;
            })
            ->editColumn('dp', function ($pembatalan) {
                return $pembatalan->status_dp;
            })
            ->editColumn('diajukan', function ($pembatalan) {
                return $pembatalan->diajukan;
            })
            ->editColumn('status', function ($pembatalan) {
                return '<span class="custom-badge status-">' . $pembatalan->status . '</span>';
            })
            ->editColumn('refund', function ($pembatalan) {
                return $pembatalan->status_approval;
            })
            ->editColumn('action', function ($data) {
                
                $tindakan = PembatalanUnit::where('id', $data->id)->where('status', 'Pending')->get();
                if (count($tindakan)==0){
                    return "Not Found";
                 
            }else {
                
                $button = '<a href="' . route('admin.pembatalans.update', $data->id) . '"  class="custom-badge status-green"><i class="fa-solid fa-check-to-slot"></i></a>';
                return $button;
            
             
                } 
            
            })
            ->addIndexColumn()
            ->rawColumns(['no_pembatalan', 'status', 'refund','action'])
            ->make(true);
            // ->addColumn('action', function ($row) {
            //     $html = '<a href="" class="btn btn-xs btn-secondary">Edit</a> ';
            //     $html .= '<button data-rowid="'.$row->id.'" class="btn btn-xs btn-danger">Del</button>';
            //     return $html;
            // })
            
            // ->toJson()
        }
    }

    public function ajax_customer()
    {
        $reinbursts = Reinburst::
        leftJoin('rincian_reinbursts','reinbursts.nomor_reinburst','=','rincian_reinbursts.nomor_reinburst')
        ->select('reinbursts.id_user','reinbursts.nomor_reinburst','reinbursts.status_hrd','reinbursts.status_pembayaran','reinbursts.tanggal_reinburst',
        'rincian_reinbursts.total','reinbursts.id')
        ->groupBy('reinbursts.nomor_reinburst')
        ->orderBy('reinbursts.id', 'desc')->where('reinbursts.status_hrd','completed')
        ->get();
        // dd($reinbursts);

        return datatables()
            ->of($reinbursts)
            ->editColumn('no_reinburst', function ($reinburst) {
                return $reinburst->nomor_reinburst;
            })
            ->editColumn('tanggal', function ($reinburst) {
                return Carbon::parse($reinburst->tanggal_reinburst)->format('d/m/Y');
            })
            ->editColumn('total', function ($reinburst) {
                return \App\Reinburst::where('nomor_reinburst', $reinburst->nomor_reinburst)->count();
            })
            ->editColumn('pembelian', function ($reinburst) {
                return $reinburst->total;
            })
            ->editColumn('status_hrd', function ($reinburst) {
                if($reinburst->status_hrd == 'pending'){
               return '<a class="custom-badge status-red">pending</a>';
               }
                if($reinburst->status_hrd == 'completed'){
                    return '<a class="custom-badge status-green">completed</a>';
                }
                if($reinburst->status_hrd == 'review'){
                    return '<a class="custom-badge status-orange">review</a>';
                }
            })
            ->editColumn('status_pembayaran', function ($reinburst) {
                if($reinburst->status_pembayaran == 'pending'){
                    return '<a class="custom-badge status-red">pending</a>';
                    }
                     if($reinburst->status_pembayaran == 'completed'){
                         return '<a class="custom-badge status-green">completed</a>';
                     }
                     if($reinburst->status_pembayaran == 'review'){
                         return '<a class="custom-badge status-orange">review</a>';
                     }
            })
            ->addIndexColumn()
            ->rawColumns(['pembelian','status_hrd','status_pembayaran'])
            ->make(true);
    }
    
}
