<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Komisi;
use App\Payment;
use App\RincianKomisi;
use App\RincianPembayaran;
use App\Tindakan;
use App\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Booking::with('pasien', 'dokter', 'cabang')->get();
        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Booking $appointment)
    {
        $appointment = Booking::with('pasien', 'dokter', 'cabang', 'perawat', 'resepsionis', 'rincian', 'tindakan')->where('id', $appointment->id)->first();
        $payments = Payment::where('id', '!=', 4)->get();

        return view('appointments.show', compact('appointment', 'payments'));
    }

    public function edit(Booking $booking)
    {
        //
    }

    public function update(Request $request, Booking $booking)
    {
        //
    }

    public function destroy(Booking $booking)
    {
        //
    }

    public function voucher()
    {
        $voucher = Voucher::where('kode_voucher', request('kode_voucher'))->first();
        $date = Carbon::now();
        $booking = Booking::with('kedatangan')->find(request('booking_id'));

        $data = request()->except('_token', 'kode_voucher');
        $data['kasir_id'] = auth()->user()->id;
        $data['payment_id'] = 4;
        $data['tanggal_pembayaran'] = $date;
        $data['voucher_id'] = $voucher->id;
        $data['biaya_kartu'] = 0;
        $data['is_active'] = 1;

        if ($voucher->is_active == 1) {
            if ($date > $voucher->tgl_mulai && $date < $voucher->tgl_akhir) {
                if ($voucher->min_transaksi != 0) {
                    if (request('dibayar') >= $voucher->min_transaksi) {
                        if ($voucher->nominal != 0) {
                            $data['nominal'] = $voucher->nominal;
                            $data['dibayar'] = $voucher->nominal;
                            $data['disc_vouc'] = $voucher->nominal;
                            RincianPembayaran::create($data);

                            $rincian = RincianPembayaran::where('booking_id', request('booking_id'))->get();

                            $voucher->update([
                                'is_active' => 0
                            ]);

                            if ($booking->kedatangan->id == 3) {

                                $this->dokter($rincian, $booking);
                                $this->resepsionis($rincian, $booking);
                                $this->marketing($rincian, $booking);
                                $this->ob($rincian, $booking);
                                $this->perawat($rincian, $booking);
                            } else {
                                $this->dokter($rincian, $booking);
                            }

                            return response()->json([
                                'success' => true,
                                'nml' => request('nominal') - $voucher->nominal,
                                'nominal' => number_format(request('nominal') - $voucher->nominal, 0, ',', '.'),
                                'status' => 200,
                                'message' => "Kode Voucher berhasil digunakan"
                            ]);
                        } else {
                            $data['nominal'] = (request('dibayar') * $voucher->persentase) / 100;
                            $data['dibayar'] = (request('dibayar') * $voucher->persentase) / 100;
                            $data['disc_vouc'] = $voucher->persentase;
                            RincianPembayaran::create($data);
                            $rincian = RincianPembayaran::where('booking_id', request('booking_id'))->get();

                            $voucher->update([
                                'is_active' => 0
                            ]);

                            if ($booking->kedatangan->id == 3) {

                                $this->dokter($rincian, $booking);
                                $this->resepsionis($rincian, $booking);
                                $this->marketing($rincian, $booking);
                                $this->ob($rincian, $booking);
                                $this->perawat($rincian, $booking);
                            } else {
                                $this->dokter($rincian, $booking);
                            }

                            return response()->json([
                                'success' => true,
                                'nml' => request('nominal') - $data['dibayar'],
                                'nominal' => number_format(request('nominal') - $data['dibayar'], 0, ',', '.'),
                                'status' => 200,
                                'message' => "Kode Voucher berhasil digunakan "
                            ]);
                        }
                    } else {
                        return response()->json([
                            'status' => 400,
                            'message' => "Minimal Transaksi Rp. " . number_format($voucher->min_transaksi, 0, ',', '.')
                        ]);
                    }
                } else {
                    if ($voucher->nominal != 0) {
                        $data['nominal'] = $voucher->nominal;
                        $data['dibayar'] = $voucher->nominal;
                        $data['disc_vouc'] = $voucher->nominal;
                        RincianPembayaran::create($data);

                        $rincian = RincianPembayaran::where('booking_id', request('booking_id'))->get();

                        $voucher->update([
                            'is_active' => 0
                        ]);

                        if ($booking->kedatangan->id == 3) {

                            $this->dokter($rincian, $booking);
                            $this->resepsionis($rincian, $booking);
                            $this->marketing($rincian, $booking);
                            $this->ob($rincian, $booking);
                            $this->perawat($rincian, $booking);
                        } else {
                            $this->dokter($rincian, $booking);
                        }

                        return response()->json([
                            'success' => true,
                            'nml' => request('nominal') - $voucher->nominal,
                            'nominal' => number_format(request('nominal') - $voucher->nominal, 0, ',', '.'),
                            'status' => 200,
                            'message' => "Kode Voucher berhasil digunakan"
                        ]);
                    } else {
                        $data['nominal'] = (request('dibayar') * $voucher->persentase) / 100;
                        $data['dibayar'] = (request('dibayar') * $voucher->persentase) / 100;
                        $data['disc_vouc'] = $voucher->persentase;
                        RincianPembayaran::create($data);
                        $rincian = RincianPembayaran::where('booking_id', request('booking_id'))->get();

                        $voucher->update([
                            'is_active' => 0
                        ]);

                        if ($booking->kedatangan->id == 3) {

                            $this->dokter($rincian, $booking);
                            $this->resepsionis($rincian, $booking);
                            $this->marketing($rincian, $booking);
                            $this->ob($rincian, $booking);
                            $this->perawat($rincian, $booking);
                        } else {
                            $this->dokter($rincian, $booking);
                        }

                        return response()->json([
                            'success' => true,
                            'nml' => request('nominal') - $data['dibayar'],
                            'nominal' => number_format(request('nominal') - $data['dibayar'], 0, ',', '.'),
                            'status' => 200,
                            'message' => "Kode Voucher berhasil digunakan "
                        ]);
                    }
                }
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => "Kode Voucher sudah tidak berlaku"
                ]);
            }
        } else {
            return response()->json([
                'status' => 400,
                'message' => "Kode Voucher tidak dapat digunakan"
            ]);
        }
    }

    public function bayar(Request $request)
    {
        $payment = Payment::find($request->input('payment'));
        $biaya =  ($request->input('bayar') * $payment->potongan) / 100;
        $booking = Booking::with('kedatangan')->find($request->input('booking_id'));

        $rincian = RincianPembayaran::where('booking_id', $booking->id)->get();

        RincianPembayaran::create([
            'booking_id' => $request->input('booking_id'),
            'kasir_id' => auth()->user()->id,
            'payment_id' => $request->input('payment'),
            'tanggal_pembayaran' => $request->input('tanggal_pembayaran'),
            'nominal' => $request->input('bayar'),
            'dibayar' => $request->input('bayar'),
            'kembali' => $request->input('kembali'),
            'biaya_kartu' => $biaya,
            'is_active' => 1
        ]);

        $rincian = RincianPembayaran::where('booking_id', $booking->id)->get();

        if ($booking->kedatangan->id == 3) {

            $this->dokter($rincian, $booking);
            $this->resepsionis($rincian, $booking);
            $this->marketing($rincian, $booking);
            $this->ob($rincian, $booking);
            $this->perawat($rincian, $booking);
        } else {
            $this->dokter($rincian, $booking);
        }


        return back();
    }

    public function dokter($dokter, $booking)
    {
        $komisi = Komisi::where('role_id', 2)->first();

        RincianKomisi::create([
            'booking_id' => $booking->id,
            'user_id' => $booking->dokter_id,
            'nominal_komisi' => ($dokter->sum('dibayar') * $komisi->persentase) / 100,
            'is_active' => 1
        ]);
    }

    public function resepsionis($resepsionis, $booking)
    {
        return $resepsionis;
        $komisi = Komisi::where('role_id', 3)->first();

        if ($resepsionis->sum('dibayar') >= $komisi->min_transaksi) {
            RincianKomisi::create([
                'booking_id' => $booking->id,
                'user_id' => $booking->resepsionis_id,
                'nominal_komisi' => ($resepsionis->sum('dibayar') * $komisi->persentase) / 100,
                'is_active' => 1
            ]);
        }
    }

    public function marketing($marketing, $booking)
    {
        $komisi = Komisi::where('role_id', 4)->first();
        if ($marketing->sum('dibayar') >= $komisi->min_transaksi) {
            RincianKomisi::create([
                'booking_id' => $booking->id,
                'user_id' => $booking->marketing_id,
                'nominal_komisi' => ($marketing->sum('dibayar') * $komisi->persentase) / 100,
                'is_active' => 1
            ]);
        }
    }

    public function ob($ob, $booking)
    {
        $komisi = Komisi::where('role_id', 5)->first();
        if ($ob->sum('dibayar') >= $komisi->min_transaksi) {
            RincianKomisi::create([
                'booking_id' => $booking->id,
                'user_id' => $booking->ob_id,
                'nominal_komisi' => ($ob->sum('dibayar') * $komisi->persentase) / 100,
                'is_active' => 1
            ]);
        }
    }

    public function perawat($perawat, $booking)
    {
        $komisi = Komisi::where('role_id', 6)->first();
        if ($perawat->sum('dibayar') >= $komisi->min_transaksi) {
            RincianKomisi::create([
                'booking_id' => $booking->id,
                'user_id' => $booking->perawat_id,
                'nominal_komisi' => ($perawat->sum('dibayar') * $komisi->persentase) / 100,
                'is_active' => 1
            ]);
        }
    }
}
